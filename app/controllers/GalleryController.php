<?php

namespace App\Controllers;

use App\Models\Image;

class GalleryController {
    public function index() {
        $images = Image::getAll();
        require_once __DIR__ . '/../../views/Gallery.php';
    }

    public function upload() {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $result = Image::upload($_FILES['file']);

            if($result['success']) {
                header('Location: /gallery');
                exit();
            } 
            else {
                $error = $result['error'];
                require_once __DIR__ . '/../../views/UploadForm.php';
            }
        }
        else {
            require_once __DIR__ . '/../../views/UploadForm.php';
        }
    }

    public function save()
    {
        // if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        //     $image = Image::getById($_POST['id']);
        //     $image->title = $_POST['title'];
        //     $image->description = $_POST['description'];
        //     $image->save();
        //     header('Location: /gallery');
        //     exit();
        // }
    }
}