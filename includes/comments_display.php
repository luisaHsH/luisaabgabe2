<?php

require_once 'includes/CommentManager.php';

$commentManager = new CommentManager();
$seite = basename($_SERVER["PHP_SELF"]);
$kommentare = $commentManager->getCommentsForPage($seite);
?>
<!-- Antwort-section -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="mt-5">Kommentare</h3>
            <div class="bg-light p-3 rounded shadow-sm">
                <?php if (empty($kommentare)) : ?>
                    <p>Noch keine Kommentare vorhanden.</p>
                <?php else: ?>
                    <?php foreach ($kommentare as $kommentar): ?>
                        <div class="mb-4 p-3 border rounded">
                            <strong><?= htmlspecialchars($kommentar["name"]) ?></strong>
                            <small class="text-muted">(<?= $kommentar["zeitpunkt"] ?>)</small>
                            <p><?= nl2br(htmlspecialchars($kommentar["kommentar"])) ?></p>
                            <!-- Zeig die älteren Antworten -->
                            <?php
                            $antworten = $commentManager->getRepliesForComment($kommentar["id"]);
                            foreach ($antworten as $antwort):
                            ?>
                                <div class="ms-4 mt-2 p-2 border-start border-secondary bg-light">
                                    <strong><?= htmlspecialchars($antwort["name"]) ?></strong>
                                    <small class="text-muted">(<?= $antwort["zeitpunkt"] ?>)</small>
                                    <p><?= nl2br(htmlspecialchars($antwort["kommentar"])) ?></p>
                                </div>
                            <?php endforeach; ?>
                            <!-- Reply-Feld -->
                            <form method="post" action="handle_reply.php" class="ms-4 mt-3">
                                <input type="hidden" name="seite" value="<?= $seite ?>">
                                <input type="hidden" name="parent_id" value="<?= $kommentar["id"] ?>">
                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control mb-1" placeholder="Dein Name" required>
                                    <textarea name="kommentar" class="form-control mb-1" rows="2" placeholder="Antwort schreiben..." required></textarea>
                                    <button type="submit" class="btn btn-sm btn-outline-primary" name="absenden">Antworten</button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
