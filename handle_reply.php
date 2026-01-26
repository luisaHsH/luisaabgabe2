<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/includes/CommentManager.php';
$cm = new CommentManager();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

$seite = basename((string)($_POST['seite'] ?? 'index.php'));
$kommentarId = (int)($_POST['kommentar_id'] ?? 0);
$name = trim((string)($_POST['name'] ?? ''));
$antwort = trim((string)($_POST['antwort'] ?? ''));

if ($kommentarId <= 0 || $name === '' || $antwort === '') {
  header('Location: ' . $seite . '?err=1#comments');
  exit;
}

$cm->addReply($kommentarId, $name, $antwort);

header('Location: ' . $seite . '#comments');
exit;
