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
$name = trim((string)($_POST['name'] ?? ''));
$kommentar = trim((string)($_POST['kommentar'] ?? ''));

if ($name === '' || $kommentar === '') {
  header('Location: ' . $seite . '?err=1#comments');
  exit;
}

$cm->addComment($seite, $name, $kommentar);

header('Location: ' . $seite . '#comments');
exit;
