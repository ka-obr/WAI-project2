<?php

namespace App\Controllers;

use App\Models\Image;

class GalleryController {    

    public function __construct() {
        session_start();
    }
    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 2;
        $offset = ($page - 1) * $limit;

        $imageModel = new Image();
        $images = $imageModel->getAll($limit, $offset);
        $totalImages = $imageModel->countAll();
        $totalPages = ceil($totalImages / $limit);

        $preparedImages = array_map(function($image) {
            return [
                'thumbnail' => 'images/thumbnail_' . $image->fileName,
                'watermarked' => 'images/watermarked_' . $image->fileName,
                'checked' => in_array($image->fileName, $_SESSION['remembered'] ?? []) ? 'checked' : '',
                'title' => $image->title,
                'author' => $image->author,
                'fileName' => $image->fileName
            ];
        }, $images);

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
                header('Location: /MojaStrona/gallery');
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
            header('Location: /MojaStrona/gallery');
            exit();
        }
    }

    public function remember() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) {
            if (!isset($_SESSION['remembered'])) {
                $_SESSION['remembered'] = [];
            }
            $_SESSION['remembered'] = array_unique(array_merge($_SESSION['remembered'], $_POST['remember']));
        } else {
            $_SESSION['remembered'] = [];
        }
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        header("Location: /MojaStrona/gallery?page=$page");
        exit();
    }
}