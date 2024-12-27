<?php

namespace App\Services;

class ImageProcessor {
    private static $uploadDir = __DIR__ . '/../../images/';

    public static function process($target, $fileName, $watermark) {
        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName;
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName;

        ImageService::createThumbnail($target, $thumbnailPath, pathinfo($fileName, PATHINFO_EXTENSION));
        ImageService::createWatermark($target, $watermarkedPath, pathinfo($fileName, PATHINFO_EXTENSION), $watermark);
    }
}