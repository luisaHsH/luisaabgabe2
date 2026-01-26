<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

class CommentManager {
  private PDO $pdo;

  public function __construct() {
    $this->pdo = db();
  }

  public function ensureReiseExists(string $seite): void {
    $stmt = $this->pdo->prepare("INSERT IGNORE INTO reisen (seite) VALUES (:seite)");
    $stmt->execute([':seite' => $seite]);
  }

  public function addComment(string $seite, string $name, string $kommentar): void {
    $this->ensureReiseExists($seite);

    $stmt = $this->pdo->prepare("
      INSERT INTO kommentare (name, kommentar, reise_id)
      VALUES (:name, :kommentar, :reise_id)
    ");
    $stmt->execute([
      ':name' => $name,
      ':kommentar' => $kommentar,
      ':reise_id' => $seite
    ]);
  }

  public function addReply(int $kommentarId, string $name, string $antwort): void {
    $stmt = $this->pdo->prepare("
      INSERT INTO antworten (kommentar_id, name, antwort)
      VALUES (:kommentar_id, :name, :antwort)
    ");
    $stmt->execute([
      ':kommentar_id' => $kommentarId,
      ':name' => $name,
      ':antwort' => $antwort
    ]);
  }

  public function getCommentsWithReplies(string $seite): array {
    $stmt = $this->pdo->prepare("
      SELECT id, name, kommentar, zeitpunkt
      FROM kommentare
      WHERE reise_id = :reise_id
      ORDER BY zeitpunkt DESC
    ");
    $stmt->execute([':reise_id' => $seite]);
    $comments = $stmt->fetchAll();

    if (!$comments) return [];

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

    $replyMap = [];
    foreach ($replies as $r) {
      $replyMap[(int)$r['kommentar_id']][] = $r;
    }

    foreach ($comments as &$c) {
      $c['replies'] = $replyMap[(int)$c['id']] ?? [];
    }
    unset($c);

    return $comments;
  }
}
