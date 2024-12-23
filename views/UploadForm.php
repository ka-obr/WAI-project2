<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/MojaStrona/web/css/style.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/zoomer.css">
    <link rel = "stylesheet" href="/MojaStrona/web/css/gallery.css">
    <title>Prześlij obraz</title>
</head>
<body>
    <header>
        <h1>Przesyłanie zdjęcia</h1>
    </header>

    <main>
        <div class="tlo-prostokatne">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="/MojaStrona/upload" method="post" enctype="multipart/form-data">
                <label for="image">Wybierz plik do przesłania (PNG/JPG, max 1 MB):</label>
                <input type="file" name="image" id="image" required>

                <label for="watermark">Znak wodny:</label>
                <input type="text" name="watermark" id="watermark" required>

                <br>
                <button type="submit">Wyślij</button>
            </form>

            <br>
            <a href="/MojaStrona/gallery">Powrót do galerii</a>
        </div>
    </main>

    <footer>
        <p>Copyright © 2024 Karol Obrycki</p>
    </footer>
</body>
</html>