<?php

namespace App\Models;

use App\Services\ImageService;

class Image {
    private static $uploadDir = __DIR__ . '/../../images/';
    private const ALLOWED_TYPES = ['image/png', 'image/jpeg'];
    private const MAX_SIZE = 1 * 1024 * 1024;

    public static function getAll($limit = 2, $offset = 0) {
        $images = glob(self::$uploadDir . 'thumbnail_*.{jpg,jpeg,png}', GLOB_BRACE);
        $images = array_map(function($image) {
            return str_replace('thumbnail_', '', basename($image));
        }, $images);
        return array_slice($images, $offset, $limit);
    }

    public static function countAll() {
        return count(glob(self::$uploadDir . 'thumbnail_*.{jpg,jpeg,png}', GLOB_BRACE));
    }

    public static function save($file, $watermark) {
        $fileName = basename($file['name']);
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];
        $target = self::$uploadDir . $fileName;

        $errors = self::validateFile($fileType, $fileSize);
        if (!empty($errors)) {
            return ['success' => false, 'error' => implode(' ', $errors)];
        }

        if (move_uploaded_file($file['tmp_name'], $target)) {
            self::processImage($target, $fileName, $watermark);
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Nie udało się przesłać pliku.'];
        }
    }

    private static function validateFile($fileType, $fileSize) {
        $errors = [];
        if (!in_array($fileType, self::ALLOWED_TYPES)) {
            $errors[] = 'Niedozwolony format pliku.';
        }
        if ($fileSize > self::MAX_SIZE) {
            $errors[] = 'Plik jest za duży.';
        }
        return $errors;
    }

    private static function processImage($target, $fileName, $watermark) {
        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName;
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName;

        ImageService::createThumbnail($target, $thumbnailPath, pathinfo($fileName, PATHINFO_EXTENSION));
        ImageService::createWatermark($target, $watermarkedPath, pathinfo($fileName, PATHINFO_EXTENSION), $watermark);
    }
}