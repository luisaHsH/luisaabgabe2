<?php
require_once 'includes/CommentManager.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["absenden"])) {
    if (!empty($_POST["name"]) && !empty($_POST["kommentar"]) && !empty($_POST["parent_id"])) {
        $name = trim($_POST["name"]);
        $kommentar = trim($_POST["kommentar"]);
        $parent_id = (int)$_POST["parent_id"];
        $seite = trim($_POST["seite"]);

        $commentManager = new CommentManager();
        $commentManager->saveReply($name, $kommentar, $parent_id);

        // Zurück zur ursprünglichen Seite
        header("Location: " . $seite);
        exit;
    } else {
        die("❌ Fehler: Alle Felder müssen ausgefüllt sein.");
    }
} else {
    die("❌ Ungültiger Zugriff.");
}
?>
