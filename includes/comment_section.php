<?php
declare(strict_types=1);

require_once __DIR__ . '/CommentManager.php';
$cm = new CommentManager();

$seite = basename($_SERVER['SCRIPT_NAME']);
$comments = $cm->getCommentsWithReplies($seite);

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>

<section id="comments" style="margin-top:30px;">
  <h2>Hinterlasse einen Kommentar</h2>

  <?php if (isset($_GET['err'])): ?>
    <p style="color:red;">Bitte fülle alle Felder aus.</p>
  <?php endif; ?>

  <form method="post" action="handle_comment.php">
    <input type="hidden" name="seite" value="<?= h($seite) ?>">
    <input name="name" required placeholder="Dein Name" style="width:100%;padding:8px;margin:6px 0;">
    <textarea name="kommentar" required placeholder="Dein Kommentar" style="width:100%;padding:8px;min-height:90px;margin:6px 0;"></textarea>
    <button type="submit">Absenden</button>
  </form>

  <hr style="margin:20px 0;">

  <h2>Kommentare</h2>

  <?php if (!$comments): ?>
    <p>Noch keine Kommentare.</p>
  <?php else: ?>
    <?php foreach ($comments as $c): ?>
      <div style="border:1px solid #ddd;padding:12px;border-radius:8px;margin:12px 0;">
        <strong><?= h((string)$c['name']) ?></strong>
        <small> – <?= h((string)$c['zeitpunkt']) ?></small>
        <p style="white-space:pre-wrap;"><?= h((string)$c['kommentar']) ?></p>

        <?php if (!empty($c['replies'])): ?>
          <div style="margin-top:10px;padding-left:14px;border-left:3px solid #eee;">
            <?php foreach ($c['replies'] as $r): ?>
              <div style="margin:10px 0;">
                <strong><?= h((string)$r['name']) ?></strong>
                <small> – <?= h((string)$r['zeitpunkt']) ?></small>
                <div style="white-space:pre-wrap;"><?= h((string)$r['antwort']) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <details style="margin-top:10px;">
          <summary>Antworten</summary>
          <form method="post" action="handle_reply.php" style="margin-top:10px;">
            <input type="hidden" name="seite" value="<?= h($seite) ?>">
            <input type="hidden" name="kommentar_id" value="<?= (int)$c['id'] ?>">
            <input name="name" required placeholder="Dein Name" style="width:100%;padding:8px;margin:6px 0;">
            <textarea name="antwort" required placeholder="Deine Antwort" style="width:100%;padding:8px;min-height:70px;margin:6px 0;"></textarea>
            <button type="submit">Antwort senden</button>
          </form>
        </details>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</section>
