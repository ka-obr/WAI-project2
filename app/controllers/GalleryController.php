<?php

namespace App\Controllers;

use App\Models\Image;

class GalleryController {
    public function index() {
        $images = Image::getAll();
        require_once __DIR__ . '/../../views/Gallery.php';
    }

    public function upload() {
        require_once __DIR__ . '/../../views/UploadForm.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $result = Image::save($_FILES['image']);

            if ($result['success']) {
                header('Location: /MojaStrona/gallery');
                exit();
            } else {
                $error = $result['error'];
                require_once __DIR__ . '/../../views/UploadForm.php';
            }
        } 
        else {
            require_once __DIR__ . '/../../views/UploadForm.php';
        }
    }
}