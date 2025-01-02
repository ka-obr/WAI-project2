<!DOCTYPE html>
<html lang="pl" class="no_js">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "/web/css/style.css">
    <link rel = "stylesheet" href = "/web/css/gallery.css">
    <title>Galeria zdjęć</title>
</head>
<body>
    <header>
        <h1>Galeria zdjęć</h1>
        <svg width="20" height="20" style="vertical-align: middle; margin-left: 8px;">
            <rect width="20" height="20" fill="#f0c674" rx="4" />
        </svg>
    </header>

    <nav>
        <ul>
            <li><a href = "/remembered">Zapamiętane zdjęcia</a></li>
            <li><a href = "/upload">Prześlij zdjęcie</a></li>
            <li><a href = "/resetSession">Restart sesji</a></li>
        </ul>
    </nav>
    
    <main>
        <div class="tlo-prostokatne">
            <h2>Galeria zdjęć</h2>
            
            <form action="/remember" method="post">
                <input type="hidden" name="page" value="<?= $page ?>">
                <div class="gallery">
                    <?php if (empty($preparedImages)): ?>
                        <p>Brak przesłanych zdjęć.</p>
                    <?php else: ?>
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
                                <a href="/delete?fileName=<?= htmlspecialchars($image['fileName']) ?>" class="delete-button">Usuń</a>
                            </figure>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="center-button">Zapamiętaj wybrane</button>
            </form>

            <br>
            <div class="pagination">
                <?php if ($totalPages > 1): ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                <?php endif; ?>
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