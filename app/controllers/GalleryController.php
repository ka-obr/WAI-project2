<?php

namespace App\Controllers;

use App\Services\GalleryService;
use App\Models\Image;

require_once __DIR__ . '/../config/GalleryLimit.php';

class GalleryController {    

    private $galleryService;

    public function __construct() {
        session_start();
        $this->galleryService = new GalleryService();
    }
    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = GALLERY_LIMIT;

        $data = $this->galleryService->getGalleryImages($page, $limit);

        $preparedImages = $data['images'];
        $totalPages = $data['totalPages'];
        $page = $data['page'];

        require_once __DIR__ . '/../../views/Gallery.php';
    }

    public function upload() {
        include __DIR__ . '/../../views/UploadForm.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['watermark'])) {
            $imageModel = new Image();
            $result = $imageModel->save($_FILES['image'], $_POST['title'], $_POST['author'], $_POST['watermark']);
    
            if ($result['success']) {
                header('Location: /gallery');
                exit();
            } else {
                $error = $result['error'];
                include __DIR__ . '/../../views/UploadForm.php';
            }
        } 
        else {
            include __DIR__ . '/../../views/UploadForm.php';
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fileName'])) {
            $imageModel = new Image();
            $imageModel->delete($_GET['fileName']);
            header('Location: /gallery');
            exit();
        }
    }

    public function resetSession() {
        session_destroy();
        header('Location: /gallery');
        exit();
    }
}