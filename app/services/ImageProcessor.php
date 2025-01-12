<?php

namespace App\Services; //deklaracja przestrzeni nazw 'App\Services', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

class ImageProcessor { //Definicja klasy 'ImageProcessor', która będzie przetwarzać obrazy
    private static $uploadDir = __DIR__ . '/../../images/'; //Deklatacja statycznej zmiennej $uploadDir, która przechowuje ścieżkę do katalogu z obrazami

    public static function process($target, $fileName, $watermark) { //Metoda 'process', która przetwarza obraz
        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName; //Ścieżka do miniatury obrazu
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName; //Ścieżka do obrazu z znakiem wodnym

        ImageService::createThumbnail($target, $thumbnailPath, pathinfo($fileName, PATHINFO_EXTENSION)); //Utworzenie miniatury obrazu za pomocą klasy 'ImageService'
        ImageService::createWatermark($target, $watermarkedPath, pathinfo($fileName, PATHINFO_EXTENSION), $watermark); //Utworzenie obrazu z znakiem wodnym za pomocą klasy 'ImageService'
    }
}