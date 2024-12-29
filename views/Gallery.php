<!DOCTYPE html>
<html lang="pl" class="no_js">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="/MojaStrona/web/css/zoomer.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/style.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/gallery.css">
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

            <form action="/MojaStrona/remember" method="post">
                <input type="hidden" name="page" value="<?= $page ?>">
                <div class="gallery">
                    <?php foreach ($preparedImages as $image): ?>
                        <figure>
                            <a href="<?= htmlspecialchars($image['watermarked']) ?>">
                                <img src="<?= htmlspecialchars($image['thumbnail']) ?>" alt="Zdjęcie" class="thumbnail">
                            </a>
                            <figcaption>
                                <strong>Tytuł:</strong> <?= htmlspecialchars($image['title']) ?><br>
                                <strong>Autor:</strong> <?= htmlspecialchars($image['author']) ?>
                            </figcaption>
                            <input type="checkbox" name="remember[]" value="<?= htmlspecialchars($image['fileName']) ?>" <?= $image['checked'] ?>>
                            <a href="/MojaStrona/delete?fileName=<?= htmlspecialchars($image['fileName']) ?>" class="delete-button">Usuń</a>
                        </figure>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="center-button">Zapamiętaj wybrane</button>
            </form>

            <br>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
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