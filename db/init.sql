-- Datei: init.sql (kannst du in SQLite importieren)

CREATE TABLE reisen (
    seite TEXT PRIMARY KEY,         -- z. B. 'mallorca.php'
    beschreibung TEXT
);

CREATE TABLE kommentare (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    kommentar TEXT NOT NULL,
    reise_id TEXT NOT NULL, -- muss TEXT sein wie reisen.seite
    zeitpunkt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reise_id) REFERENCES reisen(seite)
);

CREATE TABLE antworten (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    parent_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    kommentar TEXT NOT NULL,
    zeitpunkt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES kommentare(id)
);


-- Erster Eintrag: Mallorca
INSERT INTO reisen ( seite, beschreibung)
VALUES (  'mallorca.php', 'Meine Reise in Mallorca');

-- Zweiter Eintrag: Martinique (Beispiel)
INSERT INTO reisen (seite, beschreibung)
VALUES ('martinique.php','Inselerlebnis in der Karibik');

-- dritter Eintrag: Martinique (Beispiel)
INSERT INTO reisen (seite, beschreibung)
VALUES ('Frankreich.php','schöne Paris');