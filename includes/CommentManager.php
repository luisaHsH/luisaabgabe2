<?php

class CommentManager
{
    private PDO $conn;
    private string $dbFile = __DIR__ . '/../db/reiseapp.sqlite';
    private string $initFile = __DIR__ . '/../db/init.sql';

    public function __construct()
    {
        // Verbindung aufbauen
        $this->conn = new PDO('sqlite:' . $this->dbFile);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Falls DB-Datei leer oder neu, initialisieren
        if (!file_exists($this->dbFile) || filesize($this->dbFile) === 0) {
            $this->initializeDatabase();
        }
    }

    private function initializeDatabase(): void
    {
        if (file_exists($this->initFile)) {
            $sql = file_get_contents($this->initFile);
            $this->conn->exec($sql);
        } else {
            die("❌ Init-Datei nicht gefunden: $this->initFile");
        }
    }

    // 1. Kommentar speichern
    public function saveComment(string $name, string $kommentar, string $seite): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO kommentare (name, kommentar, reise_id) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $kommentar, $seite]);
    }


    // 2. Antwort (Reply) speichern
    public function saveReply(string $name, string $kommentar,  int $parent_id): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO antworten (name, kommentar,  parent_id) VALUES (?, ?,?)");
        return $stmt->execute([$name, $kommentar,  $parent_id]);
    }

    // 3. Alle Hauptkommentare einer Seite lesen
    public function getCommentsForPage(string $seite): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM kommentare WHERE reise_id = ?  ORDER BY zeitpunkt DESC");
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