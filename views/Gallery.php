<!DOCTYPE html>
<html lang="pl" class="no_js">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="/MojaStrona/web/css/zoomer.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/style.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/gallery.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/MojaStrona/web/js/zoomer.js"></script>
    <title>Galeria zdjęć</title>
</head>
<body>
    <header>
        <h1>Wszystko o gitarach</h1>
        <svg width="20" height="20" style="vertical-align: middle; margin-left: 8px;">
            <rect width="20" height="20" fill="#f0c674" rx="4" />
        </svg>
    </header>
    
    <main>
        <div class="tlo-prostokatne">
            <h2>Galeria zdjęć</h2>
            <a href = "/MojaStrona/upload" class="center-text">Dodaj nowe zdjęcie</a>


            <div class="gallery">
                <?php foreach ($images as $image): ?>
                    <?php
                    $target = 'images/' . basename($image);
                    ?>
                    <figure>
                        <img src = "<?= htmlspecialchars($target) ?>" alt = "Zdjęcie" class = "thumbnail">
                        <figcaption><?= htmlspecialchars(basename($image)) ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <a>Copyright © 2024 Karol Obrycki</a>
    </footer>

    <script>
        document.documentElement.classList.remove("no_js");
    </script>
</body>
</html>