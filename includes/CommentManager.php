<?php
class CommentManager
{
    private PDO $conn;
    // Standardpfade (wie bei dir)
    private string $dbFile = __DIR__ . '/../db/reiseapp.sqlite';
    private string $initFile = __DIR__ . '/../db/init.sql';
    public function __construct()
    {
        // Falls Pfade nicht stimmen: alternative Orte probieren (ohne die Struktur zu ändern)
        if (!file_exists($this->dbFile)) {
            $altDb1 = __DIR__ . '/../reiseapp.sqlite';
            $altDb2 = __DIR__ . '/../../reiseapp.sqlite';
            if (file_exists($altDb1)) {
                $this->dbFile = $altDb1;
            } elseif (file_exists($altDb2)) {
                $this->dbFile = $altDb2;
            }
        }
        if (!file_exists($this->initFile)) {
            $altInit1 = __DIR__ . '/../init.sql';
            $altInit2 = __DIR__ . '/../../init.sql';

            if (file_exists($altInit1)) {
                $this->initFile = $altInit1;
            } elseif (file_exists($altInit2)) {
                $this->initFile = $altInit2;
            }
        }
        // Falls DB-Datei fehlt oder leer ist, erst initialisieren (Datei anlegen + Schema ausführen)
        if (!file_exists($this->dbFile) || filesize($this->dbFile) === 0) {
            $this->initializeDatabase();
        }
        // Verbindung aufbauen
        $this->conn = new PDO('sqlite:' . $this->dbFile);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    private function initializeDatabase(): void
    {
        // DB-Ordner sicherstellen, falls er nicht existiert
        $dir = dirname($this->dbFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        // Verbindung für Initialisierung (ohne $this->conn vorauszusetzen)
        $tmpConn = new PDO('sqlite:' . $this->dbFile);
        $tmpConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (file_exists($this->initFile)) {
            $sql = file_get_contents($this->initFile);
            $tmpConn->exec($sql);
        } else {
            die("❌ Init-Datei nicht gefunden.");
        }
    }
    // 1. Kommentar speichern
    public function saveComment(string $name, string $kommentar, string $seite): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO kommentare (name, kommentar, reise_id) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $kommentar, $seite]);
    }
    // 2. Antwort (Reply) speichern
    public function saveReply(string $name, string $kommentar, int $parent_id): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO antworten (name, kommentar, parent_id) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $kommentar, $parent_id]);
    }
    // 3. Alle Hauptkommentare einer Seite lesen
    public function getCommentsForPage(string $seite): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM kommentare WHERE reise_id = ? ORDER BY zeitpunkt DESC");
        $stmt->execute([$seite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 4. Alle Antworten(Replys) zu einem Kommentar lesen
    public function getRepliesForComment(int $comment_id): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM antworten WHERE parent_id = ? ORDER BY zeitpunkt ASC");
        $stmt->execute([$comment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Verbindung abrufen (optional)
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
