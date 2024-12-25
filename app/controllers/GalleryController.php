<?php

namespace App\Controllers;

use App\Models\Image;

class GalleryController {    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 2;
        $offset = ($page - 1) * $limit;

        $images = Image::getAll($limit, $offset);
        $totalImages = Image::countAll();
        $totalPages = ceil($totalImages / $limit);

        require_once __DIR__ . '/../../views/Gallery.php';
    }

    public function upload() {
        include __DIR__ . '/../../views/UploadForm.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['watermark'])) {
            $result = Image::save($_FILES['image'], $_POST['watermark']);

            if ($result['success']) {
                header('Location: /MojaStrona/gallery');
                exit();
            } 
            else {
                $error = $result['error'];
                include __DIR__ . '/../../views/UploadForm.php';
            }
        } 
        else {
            include __DIR__ . '/../../views/UploadForm.php';
        }
    }
}