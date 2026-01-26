<?php
declare(strict_types=1);

class CommentManager
{
    private PDO $pdo;

    public function __construct(string $dbFilePath)
    {
        if (!file_exists($dbFilePath)) {
            throw new RuntimeException("SQLite DB nicht gefunden: " . $dbFilePath);
        }

        $this->pdo = new PDO('sqlite:' . $dbFilePath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // SQLite: Foreign Keys müssen pro Verbindung aktiv gesetzt werden
        $this->pdo->exec('PRAGMA foreign_keys = ON;');
    }

    public function ensureReiseExists(string $seite): void
    {
        // Legt die Reise an, falls sie noch nicht existiert
        $stmt = $this->pdo->prepare("INSERT OR IGNORE INTO reisen (seite) VALUES (:seite)");
        $stmt->execute([':seite' => $seite]);
    }

    public function addComment(string $seite, string $name, string $kommentar): void
    {
        $this->ensureReiseExists($seite);

        $stmt = $this->pdo->prepare("
            INSERT INTO kommentare (name, kommentar, reise_id)
            VALUES (:name, :kommentar, :reise_id)
        ");

        $stmt->execute([
            ':name' => $name,
            ':kommentar' => $kommentar,
            ':reise_id' => $seite, // FK zu reisen.seite
        ]);
    }

    public function addReply(int $kommentarId, string $name, string $antwort): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO antworten (kommentar_id, name, antwort)
            VALUES (:kommentar_id, :name, :antwort)
        ");

        $stmt->execute([
            ':kommentar_id' => $kommentarId,
            ':name' => $name,
            ':antwort' => $antwort,
        ]);
    }

    public function getCommentsWithReplies(string $seite): array
    {
        // Kommentare holen
        $stmt = $this->pdo->prepare("
            SELECT id, name, kommentar, zeitpunkt
            FROM kommentare
            WHERE reise_id = :reise_id
            ORDER BY zeitpunkt DESC
        ");
        $stmt->execute([':reise_id' => $seite]);
        $comments = $stmt->fetchAll();

        if (!$comments) {
            return [];
        }

        // Antworten in einem Rutsch holen
        $ids = array_column($comments, 'id');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt2 = $this->pdo->prepare("
            SELECT id, kommentar_id, name, antwort, zeitpunkt
            FROM antworten
            WHERE kommentar_id IN ($placeholders)
            ORDER BY zeitpunkt ASC
        ");
        $stmt2->execute($ids);
        $replies = $stmt2->fetchAll();

        // Replies zuordnen
        $replyMap = [];
        foreach ($replies as $r) {
            $replyMap[(int)$r['kommentar_id']][] = $r;
        }

        foreach ($comments as &$c) {
            $cid = (int)$c['id'];
            $c['replies'] = $replyMap[$cid] ?? [];
        }
        unset($c);

        return $comments;
    }
}
