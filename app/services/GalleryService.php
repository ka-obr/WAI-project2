<?php

namespace App\Services; //deklaracja przestrzeni nazw 'App\Services', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Models\Image; //Importowanie klasy 'Image' z przestrzeni nazw 'App\Models'

class GalleryService { //Definicja klasy 'Gallery service', która będzie obsługiwać operacje na galerii zdjęć
    private $imageModel; //Deklaracja prywatnej zmiennej 'imageMode', która przechowuje instancję klasy 'Image'

    public function __construct() { //Konstruktor klasy 'GalleryService'
        $this->imageModel = new Image(); //Inicjalizacja zmiennej $imageModel jako nowej instancji klasy 'Image'
    }

    public function getGalleryImages($page, $limit = GALLERY_LIMIT) { //Metoda 'getGalleryImages', która pobiera zdjęcia z galerii
        $offset = ($page - 1) * $limit; //Obliczanie przesunięcia dla zapytania do bazy danych
        $images = $this->imageModel->getAll($limit, $offset); //Pobranie zdjęć z galerii za pomocą metody 'getAll' z klasy 'Image'
        $totalImages = $this->imageModel->countAll(); //Obliczenie liczby wszystkich zdjęć w galerii za pomocą metody 'countAll' z klasy 'Image'
        $totalPages = ceil($totalImages / $limit); //Obliczenie liczby wszystkich stron z zdjęciami

        $preparedImages = array_map(function($image) { //Przygotowanie zdjęć do wyświetlenia
            return [ //Zwrócenie tablicy z danymi zdjęcia
                'thumbnail' => 'images/thumbnail_' . $image->fileName, //Miniatura zdjęcia
                'watermarked' => 'images/watermarked_' . $image->fileName, //Zdjęcie z znakiem wodnym
                'checked' => in_array($image->fileName, $_SESSION['remembered'] ?? []) ? 'checked' : '', //Sprawdzenie czy zdjęcie jest zaznaczone. Działa to w taki sposób, że jeśli zdjęcie znajduje się w tablicy 'remembered', to zostanie zaznaczone
                'title' => $image->title, //Tytuł zdjęcia, gdzie $image to obiekt klasy 'Image'
                'author' => $image->author, //Autor zdjęcia
                'fileName' => $image->fileName //Nazwa pliku zdjęcia
            ];
        }, $images); //Wywołanie funkcji array_map na tablicy $images z przekazaniem funkcji anonimowej

        return [ //Zwrócenie tablicy z danymi zdjęć
            'images' => $preparedImages, //Przygotowane zdjęcia
            'totalPages' => $totalPages, //Liczba wszystkich stron z zdjęciami
            'page' => $page //Numer aktualnej strony
        ];
    }
}