<?php

namespace App\Models; //Deklaracja przestrzeni nazw 'App\Models', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Services\ImageService; //Importowanie klasy 'ImageService' z przestrzeni nazw 'App\Services'
use App\Services\FileValidator; //Importowanie klasy 'FileValidator' z przestrzeni nazw 'App\Services'
use App\Services\ImageProcessor; //Importowanie klasy 'ImageProcessor' z przestrzeni nazw 'App\Services'
use App\Repositories\ImageRepository; //Importowanie klasy 'ImageRepository' z przestrzeni nazw 'App\Repositories'

require_once __DIR__ . '/../config/GalleryLimit.php'; //Dołączenie pliku konfiguracyjnego z limitem zdjęć 'GalleryLimit.php'

class Image { //Definicja klasy 'Image', która będzie obsługiwać operacje na obrazach
    private static $uploadDir = __DIR__ . '/../../images/'; //Deklatacja statycznej zmiennej $uploadDir, która przechowuje ścieżkę do katalogu z obrazami
    private $repository; //Deklaracja prywatnej zmiennej $repository, która przechowuje instancję klasy 'ImageRepository'

    public function __construct() { //Konstruktor klasy 'Image'
        $this->repository = new ImageRepository(); //Inicjalizacja zmiennej $repository jako nowej instancji klasy 'ImageRepository'
    }

    public function getAll($limit = GALLERY_LIMIT, $offset = 0) { //Metoda 'getAll', która pobiera wszystkie obrazy z limitem i przesunięciem
        return $this->repository->getAll($limit, $offset); //Wywołanie metody 'getAll' z klasy 'ImageRepository' z parametrami $limit i $offset
    }

    public function countAll() { //Metoda 'countAll' która zwraca liczbę wszystkich obrazów
        return $this->repository->countAll(); //Wywołanie metody 'countAll' z klasy 'ImageRepository'
    }

    public function save($file, $title, $author, $watermark) { // Metoda save, która zapisuje przesłany obraz
        $fileName = basename($file['name']); //Pobiera nazwy pliku z tablicy $_FILES
        $fileSize = $file['size']; //Pobiera rozmiar pliku z tablicy $_FILES
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); //Pobiera rozszerzenie pliku z nazwy pliku
        $uniqueId = new \MongoDB\BSON\ObjectId(); //Utworzenie unikalnego ID za pomocą klasy 'ObjectId' z biblioteki MongoDB
        $newFileName = $uniqueId . '.' . $fileExtension; //Utworzenie nowej nazwy pliku z unikalnym ID i rozszerzeniem
        $target = self::$uploadDir . $newFileName; //Utworzenie pełnej ścieżki do zapisu pliku
    
        if (!is_uploaded_file($file['tmp_name'])) { //Sprawdzamy, czy plik został przesłany
            return ['success' => false, 'error' => 'Plik jest za duży lub niedozwolony format pliku.']; //Zwrócenie błędu, jeśli plik nie został przesłany
        }
    
        $finfo = finfo_open(FILEINFO_MIME_TYPE); //Otwarcie finfo do sprawdzania typu MIME pliku
        $fileType = finfo_file($finfo, $file['tmp_name']); //Pobieranie typu MIME pliku
        finfo_close($finfo); //Zamknięcie finfo
    
        $errors = FileValidator::validate($fileType, $fileSize); //Walidacja pliku za pomocą klasy 'FileValidator'
        if (!empty($errors)) { //Sprawdzenie czy są jakieś błędy
            return ['success' => false, 'error' => implode(' ', $errors)]; //Zwrócenie błędów walidacji
        }
    
        if (move_uploaded_file($file['tmp_name'], $target)) { //Przeniesienie pliku do katalogu z obrazami
            ImageProcessor::process($target, $newFileName, $watermark); //Przetworzenie obrazu za pomocą klasy 'ImageProcessor'
    
            $data = [ //Utworzenie tablicy z danymi obrazu
                'fileName' => $newFileName, //Nowa nazwa pliku
                'originalFileName' => $fileName, //Oryginalna nazwa pliku
                'title' => $title, // Tytuł obrazu
                'author' => $author, //Autor obrazu
                'watermark' => $watermark, //Znak wodny
            ];
            $this->repository->save($data); //Zapisanie danych obrazu do bazy danych za pomocą metody 'save' z klasy 'ImageRepository'
    
            return ['success' => true]; //Zwrócenie sukcesu
        } else {
            return ['success' => false, 'error' => 'Nie udało się przesłać pliku.']; //Zwrócenie błędu, jeśli nie udało się przesłać pliku
        }
    }

    public function delete($fileName) { //Metoda delete która usuwa obraz
        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName; // Scieżka do minatury obrazu
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName; //Ścieżka do obrazu ze znakiem wodnym
        $originalPath = self::$uploadDir . $fileName; //Ścieżka do oryginalnego obrazu

        if (file_exists($thumbnailPath)) { //Sprawdzenie czy istnieje miniatura obrazu
            unlink($thumbnailPath); //Usunięcie miniatury obrazu
        }
        if (file_exists($watermarkedPath)) { //Sprawdzenie czy istnieje obraz ze znakiem wodnym
            unlink($watermarkedPath); //Usunięcie obrazu ze znakiem wodnym
        }
        if (file_exists($originalPath)) { //Sprawdzenie czy istnieje oryginalny obraz
            unlink($originalPath); //Usunięcie oryginalnego obrazu
        }

        $this->repository->delete($fileName); //Usunięcie danych obrazu z bazy danych za pomocą metody 'delete' z klasy 'ImageRepository'
    }

    public function getByFileName($fileName) { //Metoda 'getByFileName', która zwraca obraz po nazwie pliku
        return $this->repository->getByFileName($fileName); //Wywołanie metody 'getByFileName' z klasy 'ImageRepository' z parametrem $fileName i zwrócenie wyniku
    }
}