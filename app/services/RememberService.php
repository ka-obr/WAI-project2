<?php

namespace App\Services;

use App\Models\Image;

class RememberService {
    private $imageModel;

    public function __construct() {
        $this->imageModel = new Image();
    }

    public function getRememberedImages($page, $limit = GALLERY_LIMIT) {
        $offset = ($page - 1) * $limit;
        $rememberedImages = [];

        if (isset($_SESSION['remembered'])) {
            $totalImages = count($_SESSION['remembered']);
            $totalPages = ceil($totalImages / $limit);
            $rememberedFileNames = array_slice($_SESSION['remembered'], $offset, $limit);

            foreach ($rememberedFileNames as $fileName) {
                $image = $this->imageModel->getByFileName($fileName);
                if ($image) {
                    $rememberedImages[] = [
                        'thumbnail' => 'images/thumbnail_' . $image->fileName,
                        'watermarked' => 'images/watermarked_' . $image->fileName,
                        'checked' => 'checked',
                        'title' => $image->title,
                        'author' => $image->author,
                        'fileName' => $image->fileName
                    ];
                }
            }
        } else {
            $totalImages = 0;
            $totalPages = 1;
        }

        return [
            'images' => $rememberedImages,
            'totalPages' => $totalPages,
            'page' => $page
        ];
    }

    public function rememberImages($remembered) {
        if (!isset($_SESSION['remembered'])) {
            $_SESSION['remembered'] = [];
        }
        foreach ($remembered as $fileName) {
            if (!in_array($fileName, $_SESSION['remembered'])) {
                $_SESSION['remembered'][] = $fileName;
            }
        }
    }

    public function removeRememberedImages($remembered) {
        if (!isset($_SESSION['remembered'])) {
            $_SESSION['remembered'] = [];
        }
        $_SESSION['remembered'] = array_values(array_diff($_SESSION['remembered'], $remembered));
    }
}