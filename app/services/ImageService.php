<?php

namespace App\Services;

class ImageService
{
    static public function createWatermark($file, $path, $extension, $text)
    {
        $createFunction = self::getCreateFunction($extension);
        $image = $createFunction($file);
        $fontColor = imagecolorallocate($image, 0x64, 0x64, 0x64);
        $fontFilename = __DIR__ . '/../../fonts/VT323-Regular.ttf';

        $result = imagettftext($image, 40, -45, 75, 75, $fontColor, $fontFilename, $text);
        $saveResult = imagepng($image, $path);
        imagedestroy($image);
    }

    static public function createThumbnail($file, $path, $extension)
    {
        $createFunction = self::getCreateFunction($extension);
        $image = $createFunction($file);

        $thumbnailWidth = 200;
        $thumbnailHeight = 125;
        $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

        $width = imagesx($image);
        $height = imagesy($image);

        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $width, $height);

        imagepng($thumbnail, $path);
        imagedestroy($image);
        imagedestroy($thumbnail);
    }

    private static function getCreateFunction($extension)
    {
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                return 'imagecreatefromjpeg';
            case 'png':
                return 'imagecreatefrompng';
            default:
                throw new \Exception('Nieobsługiwane rozszerzenie pliku');
        }
    }
}