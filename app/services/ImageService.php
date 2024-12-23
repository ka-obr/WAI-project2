<?php

namespace App\Services;

class ImageService
{
    static public function createThumbnail($file, $path, $extension)
    {
        $createFunction = self::getCreateFunction($extension);
        $image = $createFunction($file);

        $thumbnail = imagescale($image, 200, 125);

        imagedestroy($image);
        imagepng($thumbnail, $path);
    }

    static public function createWatermark($file, $path, $extension, $text)
    {
        $createFunction = self::getCreateFunction($extension);
        $image = $createFunction($file);
        $fontColor = imagecolorallocate($image, 0x64, 0x64, 0x64);
        $fontFilename = __DIR__ . '../../VT323-Regular.ttf';

        imagettftext($image, 40, -45, 75, 75, $fontColor, $fontFilename, $text);
        imagepng($image, $path);
        imagedestroy($image);
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
                throw new \Exception('Nieobsługiwany format pliku');
        }
    }
}