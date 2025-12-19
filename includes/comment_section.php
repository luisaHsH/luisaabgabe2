
<!-- Comment-section -->

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center">Hinterlasse einen Kommentar</h2>

            <!-- Formular sendet an 'kommentar_absenden.php' -->
            <form method="post" action="handle_comment.php">
                <input type="hidden" name="seite" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <input type="hidden" name="parent_id" value="">
                <div class="mb-3">
                    <label for="name" class="form-label">Dein Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="kommentar" class="form-label">Dein Kommentar</label>
                    <textarea class="form-control" name="kommentar" id="kommentar" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger" name="absenden">Absenden</button>
            </form>
        </div>
    </div>

</div>
