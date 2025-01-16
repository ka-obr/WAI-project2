<?php

namespace App\Services;

use App\Models\Image;

class GalleryService {
    private $imageModel;

    public function __construct() {
        $this->imageModel = new Image();
    }

    public function getGalleryImages($page, $limit = GALLERY_LIMIT) {
        $offset = ($page - 1) * $limit;
        $images = $this->imageModel->getAll($limit, $offset);
        $totalImages = $this->imageModel->countAll();
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

        return [
            'images' => $preparedImages,
            'totalPages' => $totalPages,
            'page' => $page
        ];
    }
}