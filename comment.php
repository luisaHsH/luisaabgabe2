    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center">Hinterlasse einen Kommentar</h2>

                <!-- Kommentar-Formular -->
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Dein Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="kommentar" class="form-label">Dein Kommentar</label>
                        <textarea class="form-control" name="kommentar" id="kommentar" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Absenden</button>
                </form>

                <!-- Kommentar speichern -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"], $_POST["kommentar"])) {
                    $name = htmlspecialchars($_POST["name"]);
                    $kommentar = htmlspecialchars($_POST["kommentar"]);

                    // aktueller Dateiname z. B. martinique.php
                    $seite = basename($_SERVER["PHP_SELF"]);

                    // Kommentar-Eintrag formatieren
                    $eintrag = "[" . date("d.m.Y H:i") . "] " .  " | " . $name . ": " . $kommentar . " | " . $seite . "\n";

                    // in Textdatei speichern
                    file_put_contents("kommentare.txt", $eintrag, FILE_APPEND);
                }
                ?>

                <!-- Kommentare anzeigen -->
                <div class="mt-5">
                    <h3>Kommentare</h3>
                    <div class="bg-light p-3 rounded shadow-sm" style="white-space: pre-line;">
                        <?php
                        $filename = "kommentare.txt";
                        $currentPage = basename($_SERVER["PHP_SELF"]);

                        if (file_exists($filename)) {
                            $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                            $found = false;

                            foreach ($lines as $line) {
                                $line = trim($line); // Entfernt führende + nachfolgende Leerzeichen

                                // Zeige nur Kommentare für diese Seite
                                if (str_ends_with($line, $currentPage)) {
                                    $parts = explode('|', $line);

                                    // Saubere Anzeige, nur wenn Struktur korrekt ist
                                    if (count($parts) >= 3) {
                                        $date = trim($parts[0]);
                                        $comment = trim($parts[1]);

                                        // Optional: eckige Klammern einfügen, wenn fehlen
                                        if (!str_starts_with($date, "[")) {
                                            $date = "[" . $date . "]";
                                        }

                                        echo htmlspecialchars("$date | $comment") . "\n";
                                        $found = true;
                                    }
                                }
                            }

                            if (!$found) {
                                echo "Noch keine Kommentare für diese Seite vorhanden.";
                            }
                        } else {
                            echo "Noch keine Kommentare vorhanden.";
                        }
                        ?>
                    </div>
                </div>
                <!-- Kommentare anzeigen -->
            </div>
        </div>
    </div>