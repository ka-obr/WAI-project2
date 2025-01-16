<?php

namespace App\Services;

class FileValidator {
    const ALLOWED_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];
    const MAX_SIZE = 1 * 1024 * 1024;

    public static function validate($fileType, $fileSize) {
        $errors = [];
        if ($fileSize > self::MAX_SIZE) {
            $errors[] = 'Plik jest za duży.';
        }
        if (!in_array($fileType, self::ALLOWED_TYPES)) {
            $errors[] = 'Niedozwolony format pliku.';
        }
        return $errors;
    }
}