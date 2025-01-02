<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "/web/css/style.css">
    <link rel = "stylesheet" href = "/web/css/gallery.css">
    <title>Prześlij obraz</title>
</head>
<body>
    <header>
        <h1>Przesyłanie zdjęcia</h1>
        <svg width="20" height="20" style="vertical-align: middle; margin-left: 8px;">
            <rect width="20" height="20" fill="#f0c674" rx="4" />
        </svg>
    </header>

    <nav>
        <ul>
            <li><a href = "/gallery">Galeria</a></li>
            <li><a href = "/remembered">Zapamiętane zdjęcia</a></li>
            <li><a href = "/resetSession">Restart sesji</a></li>
        </ul>
    </nav>

    <main>
        <div class="tlo-prostokatne">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="/upload" method="post" enctype="multipart/form-data">
                <label for="image">Wybierz plik do przesłania (PNG/JPG, max 1 MB):</label>
                <input type="file" name="image" id="image" required>

                <label for="title">Tytuł:</label>
                <input type="text" name="title" id="title" required>

                <label for="author">Autor:</label>
                <input type="text" name="author" id="author" required>

                <label for="watermark">Znak wodny:</label>
                <input type="text" name="watermark" id="watermark" required>

                <br>
                <button type="submit">Wyślij</button>
            </form>

        </div>
    </main>

    <footer>
        <p>Copyright © 2024 Karol Obrycki</p>
    </footer>
</body>
</html>