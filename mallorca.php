<!DOCTYPE html>
<html lang="de">

<head>
    
    <title>Mallorca</title>
    <?php include 'includes/packages.php'; ?>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- Seiteninhalt -->
    <div class="container my-5">

        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold">Sonneninsel Mallorca</h1>
            <p class="lead animate-text">
                Mallorca – mehr als nur Strand und Party. Die Baleareninsel begeistert mit ihrer Vielfalt aus türkisblauen Buchten,
                beeindruckender Natur, malerischen Dörfern und mediterranem Lebensgefühl. Hier teile ich meine schönsten Eindrücke.
            </p>
        </div>

        <div class="row justify-content-center">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/mallorca3.jpg" class="d-block w-100" alt="Strand auf Mallorca">
                    </div>
                    <div class="carousel-item">
                        <img src="images/mallorca2.jpg" class="d-block w-100" alt="Bucht auf Mallorca">
                    </div>
                    <div class="carousel-item">
                        <img src="images/mallorca1.jpg" class="d-block w-100" alt="Berglandschaft Mallorca">
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
                    Mein Aufenthalt auf Mallorca war geprägt von Kontrasten: Von der lebendigen Altstadt Palmas mit ihren verwinkelten Gassen
                    bis zu ruhigen Stränden wie der Cala Llombards, an denen man die Seele baumeln lassen kann.
                </p>
                <p>
                    Besonders beeindruckt haben mich die Serra de Tramuntana – das Gebirge im Nordwesten der Insel.
                    Atemberaubende Ausblicke, malerische Dörfer wie Valldemossa oder Deià und kleine Bergstraßen machen diesen Teil
                    zu einem echten Highlight für Wanderfreunde und Naturbegeisterte.
                </p>
                <p>
                    Kulinarisch hat Mallorca ebenfalls einiges zu bieten: Frischer Fisch, Tapas, Oliven und das berühmte „Ensaimada“-Gebäck –
                    dazu ein Glas lokaler Weißwein und der Abend ist perfekt.
                </p>
                <p>
                    Ich hoffe, meine Bilder und Eindrücke machen Lust darauf, Mallorca von seiner vielfältigen und authentischen Seite kennenzulernen.
                </p>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/includes/comment_section.php'; ?>
    <?php include 'includes/comments_display.php'; ?>
    <?php include 'includes/footer.php'; ?>
</body>


</html>
