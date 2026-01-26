<?php
require_once 'includes/CommentManager.php';

$cm = new CommentManager();
$cm->addReply((int)$_POST['comment_id'], $_POST['name'], $_POST['antwort']);

header("Location: " . $_POST['seite'] . "#comments");
