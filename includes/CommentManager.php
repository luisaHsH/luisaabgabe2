<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

class CommentManager {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = get_pdo();
    }

    private function ensureReise(string $seite): int {
        $this->pdo->prepare(
            "INSERT IGNORE INTO reisen (seite) VALUES (:seite)"
        )->execute(['seite' => $seite]);

        $stmt = $this->pdo->prepare(
            "SELECT id FROM reisen WHERE seite = :seite"
        );
        $stmt->execute(['seite' => $seite]);

        return (int)$stmt->fetchColumn();
    }

    public function addComment(string $seite, string $name, string $kommentar): void {
        $reiseId = $this->ensureReise($seite);

        $this->pdo->prepare(
            "INSERT INTO kommentare (reise_id, name, kommentar)
             VALUES (:reise_id, :name, :kommentar)"
        )->execute([
            'reise_id' => $reiseId,
            'name' => $name,
            'kommentar' => $kommentar
        ]);
    }

    public function addReply(int $commentId, string $name, string $antwort): void {
        $this->pdo->prepare(
            "INSERT INTO antworten (kommentar_id, name, antwort)
             VALUES (:comment_id, :name, :antwort)"
        )->execute([
            'comment_id' => $commentId,
            'name' => $name,
            'antwort' => $antwort
        ]);
    }

    public function getComments(string $seite): array {
        $reiseId = $this->ensureReise($seite);

        $stmt = $this->pdo->prepare(
            "SELECT * FROM kommentare
             WHERE reise_id = :reise_id
             ORDER BY zeitpunkt DESC"
        );
        $stmt->execute(['reise_id' => $reiseId]);
        $comments = $stmt->fetchAll();

        foreach ($comments as &$c) {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM antworten
                 WHERE kommentar_id = :id
                 ORDER BY zeitpunkt ASC"
            );
            $stmt->execute(['id' => $c['id']]);
            $c['antworten'] = $stmt->fetchAll();
        }

        return $comments;
    }

    public function deleteComment(int $id): void {
        $this->pdo->prepare(
            "DELETE FROM kommentare WHERE id = :id"
        )->execute(['id' => $id]);
    }

    public function deleteReply(int $id): void {
        $this->pdo->prepare(
            "DELETE FROM antworten WHERE id = :id"
        )->execute(['id' => $id]);
    }
}
