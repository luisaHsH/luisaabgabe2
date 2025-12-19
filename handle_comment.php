<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once __DIR__ . '/includes/CommentManager.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["absenden"])) {
    if (!empty($_POST["name"]) && !empty($_POST["kommentar"]) && !empty($_POST["seite"])) {
        $name = trim($_POST["name"]);
        $kommentar = trim($_POST["kommentar"]);
        $seite = trim($_POST["seite"]);
        try {
            $commentManager = new CommentManager();
            $commentManager->saveComment($name, $kommentar, $seite);
        } catch (Throwable $e) {
            die("❌ Fehler beim Speichern: " . $e->getMessage());
        }
        if ($seite !== '' && $seite[0] === "/") {
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


