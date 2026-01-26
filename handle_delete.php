<?php
require_once 'includes/CommentManager.php';

$cm = new CommentManager();

if ($_POST['type'] === 'comment') {
    $cm->deleteComment((int)$_POST['id']);
} else {
    $cm->deleteReply((int)$_POST['id']);
}

header("Location: " . $_POST['seite'] . "#comments");
