<?php
require_once __DIR__ . '/CommentManager.php';

$cm = new CommentManager();
$seite = basename($_SERVER['PHP_SELF']);

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$comments = $cm->getComments($seite);
?>

<h2 id="comments">Kommentare</h2>

<form method="post" action="handle_comment.php">
    <input type="hidden" name="seite" value="<?= h($seite) ?>">
    <input type="text" name="name" placeholder="Name" required>
    <textarea name="kommentar" placeholder="Kommentar" required></textarea>
    <button type="submit">Senden</button>
</form>

<?php foreach ($comments as $c): ?>
    <hr>
    <strong><?= h($c['name']) ?></strong>
    <p><?= nl2br(h($c['kommentar'])) ?></p>

    <form method="post" action="handle_delete.php">
        <input type="hidden" name="type" value="comment">
        <input type="hidden" name="id" value="<?= $c['id'] ?>">
        <input type="hidden" name="seite" value="<?= h($seite) ?>">
        <button type="submit">Löschen</button>
    </form>

    <form method="post" action="handle_reply.php">
        <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
        <input type="hidden" name="seite" value="<?= h($seite) ?>">
        <input type="text" name="name" placeholder="Name" required>
        <textarea name="antwort" placeholder="Antwort" required></textarea>
        <button type="submit">Antworten</button>
    </form>

    <?php foreach ($c['antworten'] as $r): ?>
        <div style="margin-left:20px;">
            <strong><?= h($r['name']) ?></strong>
            <p><?= nl2br(h($r['antwort'])) ?></p>

            <form method="post" action="handle_delete.php">
                <input type="hidden" name="type" value="reply">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                <input type="hidden" name="seite" value="<?= h($seite) ?>">
                <button type="submit">Löschen</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
