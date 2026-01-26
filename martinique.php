<!DOCTYPE html>
<html lang="de">

<head>
    
    <title>martinique</title>
    <?php include 'includes/packages.php'; ?>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- Startseite Inhalt -->
    <div class="container my-5">

        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold">Inseltraum Martinique</h1>
            <p class="lead animate-text">
                Martinique – die Perle der Karibik. Türkisblaues Wasser, goldene Strände und französisches Flair vereinen sich hier
                zu einem einzigartigen Urlaubserlebnis. Diese Seite gibt dir einen Einblick in meine schönsten Momente auf der Insel.
            </p>
        </div>

        <div class="row justify-content-center">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/martinique3.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/martinique2.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/martinique1.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="row mt-5 justify-content-center text-center lead animate-text">
            <div class="col-md-10">
                <p>
                    Schon bei der Ankunft auf Martinique spürt man das karibische Lebensgefühl: entspannte Musik, fröhliche Menschen
                    und eine warme Brise vom Meer. Die Hauptstadt Fort-de-France überrascht mit bunten Märkten und kolonialem Charme.
                </p>
                <p>
                    Mein persönliches Highlight war der Besuch der botanischen Gärten von Balata. Zwischen Palmen, exotischen Blüten
                    und Hängebrücken fühlte ich mich wie in einer anderen Welt. Auch die traumhaften Buchten wie Anse Dufour oder Grande Anse
                    laden zum Entspannen und Schnorcheln ein.
                </p>
                <p>
                    Kulinarisch ist Martinique ein Genuss: Frischer Fisch, tropische Früchte und französisch-kreolische Küche sind allgegenwärtig.
                    Ob beim Picknick am Strand oder in einem kleinen Restaurant mit Meerblick – überall spürt man die Herzlichkeit der Insel.
                </p>
                <p>
                    Ich hoffe, meine Bilder geben dir einen kleinen Eindruck von der Schönheit Martiniques. Vielleicht steht die Insel
                    ja bald auf deiner eigenen Reisewunschliste?
                </p>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/includes/comment_section.php'; ?>
    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>


</html>
