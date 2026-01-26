<?php
require_once 'includes/CommentManager.php';

$cm = new CommentManager();
$cm->addComment($_POST['seite'], $_POST['name'], $_POST['kommentar']);

header("Location: " . $_POST['seite'] . "#comments");
