<?php

namespace App\Models;

class Image {
    private static $uploadDir = __DIR__ . '/../../images/';

    public static function getAll() {
        return glob(self::$uploadDir . '*.{jpg,jpeg,png}', GLOB_BRACE);
    }

    public static function save($file) {
        $allowedTypes = ['image/png', 'image/jpeg'];
        $maxSize = 1 * 1024 * 1024;

        $fileName = basename($file['name']);
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];
        $target = self::$uploadDir . $fileName;

        $errors = [];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Niedozwolony format pliku';
        }

        if ($fileSize > $maxSize) {
            $errors[] = 'Plik jest za duży. Max rozmiar to 1MB';
        }

        if (!empty($errors)) {
            return ['success' => false, 'error' => implode(' oraz ', $errors)];
        }

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return ['success' => true];
        } 
        else {
            return ['success' => false, 'error' => 'Błąd podczas zapisu pliku'];
        }
    }
}
?>