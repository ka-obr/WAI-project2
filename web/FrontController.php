<?php

namespace App;

require_once __DIR__ . '/../app/controllers/GalleryController.php';
require_once __DIR__ . '/../app/models/Image.php';

use App\Controllers\GalleryController;

$galleryController = new GalleryController();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$domain = "/MojaStrona/";

if ($requestUri === $domain . 'gallery') {
    $galleryController->index();
} 
elseif ($requestUri === $domain . 'upload' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $galleryController->upload();
}
elseif ($requestUri === $domain . 'upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $galleryController->save();
}
else {
    echo '404 - Strona nie znaleziona';
}
?>