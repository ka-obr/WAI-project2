<?php

namespace App\Models;

class image {
    private static $uploadDir = __DIR__ . '/../../uploads/';

    public static function getAll() {
        return glob(self::$uploadDir . '*.{jpg,jpeg,png}', GLOB_BRACE);
    }

    public static function upload($file) {
        $allowedTypes = ['image/png', 'image/jpeg'];
        $maxSize = 1 * 1024 * 1024;

        $fileName = basename($file['name']);
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];
        $target = self::$uploadDir . $fileName;

        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Niedozwolony format pliku'];
        }

        if($fileSize > $maxSize) {
            return ['success' => false, 'error' => 'Plik jest za duży. Max rozmiar to 1MB'];
        }

        if(move_uploaded_file($file['tmp_name'], $target)) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'Błąd podczas zapisu pliku'];
        }
    }
}