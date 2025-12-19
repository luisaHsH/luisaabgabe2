<?php
require_once __DIR__ . '/includes/CommentManager.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["absenden"])) {
    if (!empty($_POST["name"]) && !empty($_POST["kommentar"]) && !empty($_POST["seite"])) {
        $name = trim($_POST["name"]);
        $kommentar = trim($_POST["kommentar"]);
        $seite = trim($_POST["seite"]);
        $commentManager = new CommentManager();
        $commentManager->saveComment($name, $kommentar, $seite);
        // Zurück zur ursprünglichen Seite (nur interne Pfade)
        if ($seite[0] === "/") {
            header("Location: " . $seite);
            exit;
        }
        header("Location: /index.php");
        exit;
    } else {
        die("❌ Fehler: Alle Felder müssen ausgefüllt sein.");
    }
} else {
    die("❌ Ungültiger Zugriff.");
}
?>
