<?php

namespace App\Services; //deklaracja przestrzeni nazw 'App\Services', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

class ImageService { //Definicja klasy 'ImageService', która będzie obsługiwać operacje na obrazach
    static public function createWatermark($file, $path, $extension, $text) { //Metoda 'createWatermark', która tworzy znak wodny na obrazie
        $createFunction = self::getCreateFunction($extension); //Pobranie funkcji do tworzenia obrazu na podstawie rozszerzenia
        $image = $createFunction($file); //Utworzenie obrazu za pomocą funkcji zwróconej przez metodę 'getCreateFunction'
        $fontColor = imagecolorallocate($image, 0x64, 0x64, 0x64); //Utworzenie koloru czcionki
        $fontFilename = __DIR__ . '/../../fonts/VT323-Regular.ttf'; //Ścieżka do pliku czcionki

        $result = imagettftext($image, 40, -45, 75, 75, $fontColor, $fontFilename, $text); //Dodanie tekstu na obrazie
        $saveResult = imagepng($image, $path); //Zapisanie obrazu z tekstem
        imagedestroy($image); //Zniszczenie obrazu, które nie są już potrzebne
    }

    static public function createThumbnail($file, $path, $extension) //Metoda 'createThumbnail', która tworzy miniaturę obrazu
    {
        $createFunction = self::getCreateFunction($extension); //Pobranie funkcji do tworzenia obrazu na podstawie rozszerzenia
        $image = $createFunction($file); //Utworzenie obrazu za pomocą funkcji zwróconej przez metodę 'getCreateFunction'

        $thumbnailWidth = 200; //Szerokość miniatury
        $thumbnailHeight = 125; //Wysokość miniatury
        $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight); //Utworzenie obrazu miniatury

        $width = imagesx($image); //Pobranie szerokości obrazu
        $height = imagesy($image); //Pobranie wysokości obrazu

        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $width, $height); //Skopiowanie i zmiana rozmiaru obrazu na miniaturę

        imagepng($thumbnail, $path); //Zapisanie miniatury obrazu
        imagedestroy($image); //Zniszczenie obrazu, które nie są już potrzebne
        imagedestroy($thumbnail); //Zniszczenie miniatury obrazu, które nie są już potrzebne
    }

    private static function getCreateFunction($extension) //Prywatna metoda 'getCreateFunction', która zwraca funkcję do tworzenia obrazu na podstawie rozszerzenia
    {
        switch ($extension) { //Sprawdzenie rozszerzenia pliku
            case 'jpeg':
            case 'jpg':
                return 'imagecreatefromjpeg'; //Zwrócenie funkcji do tworzenia obrazu z pliku JPEG
            case 'png':
                return 'imagecreatefrompng'; //Zwrócenie funkcji do tworzenia obrazu z pliku PNG
            default:
                throw new \Exception('Nieobsługiwane rozszerzenie pliku'); //Rzucenie wyjątku, jeśli rozszerzenie pliku nie jest obsługiwane
        }
    }
}