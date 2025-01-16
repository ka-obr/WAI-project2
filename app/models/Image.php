<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\FileValidator;
use App\Services\ImageProcessor;
use App\Repositories\ImageRepository;

require_once __DIR__ . '/../config/GalleryLimit.php';

class Image {
    private static $uploadDir = __DIR__ . '/../../images/';
    private $repository;

    public function __construct() {
        $this->repository = new ImageRepository();
    }

    public function getAll($limit = GALLERY_LIMIT, $offset = 0) {
        return $this->repository->getAll($limit, $offset);
    }

    public function countAll() {
        return $this->repository->countAll();
    }

    public function save($file, $title, $author, $watermark) {
        $fileName = basename($file['name']);
        $fileSize = $file['size'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueId = new \MongoDB\BSON\ObjectId();
        $newFileName = $uniqueId . '.' . $fileExtension;
        $target = self::$uploadDir . $newFileName;
    
        if (!is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'Plik jest za duży lub niedozwolony format pliku.'];
        }
    
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
    
        $errors = FileValidator::validate($fileType, $fileSize);
        if (!empty($errors)) {
            return ['success' => false, 'error' => implode(' ', $errors)];
        }
    
        if (move_uploaded_file($file['tmp_name'], $target)) {
            ImageProcessor::process($target, $newFileName, $watermark);
    
            $data = [
                'fileName' => $newFileName,
                'originalFileName' => $fileName,
                'title' => $title,
                'author' => $author,
                'watermark' => $watermark,
            ];
            $this->repository->save($data);
    
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Nie udało się przesłać pliku.'];
        }
    }

    public function delete($fileName) {
        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName;
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName;
        $originalPath = self::$uploadDir . $fileName;

        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
        if (file_exists($watermarkedPath)) {
            unlink($watermarkedPath);
        }
        if (file_exists($originalPath)) {
            unlink($originalPath);
        }

        $this->repository->delete($fileName);
    }

    public function getByFileName($fileName) {
        return $this->repository->getByFileName($fileName);
    }
}