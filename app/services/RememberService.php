<?php

namespace App\Services; //deklaracja przestrzeni nazw 'App\Services', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Models\Image; //Importowanie klasy 'Image' z przestrzeni nazw 'App\Models

class RememberService { //Definicja klasy 'RememberService', która będzie obsługiwać operacje na zapamiętanych zdjęciach
    private $imageModel; //Deklaracja prywatnej zmiennej 'imageModel', która przechowuje instancję klasy 'Image'

    public function __construct() {
        $this->imageModel = new Image(); //Inicjalizacja zmiennej $imageModel jako nowej instancji klasy 'Image'
    }

    public function getRememberedImages($page, $limit = GALLERY_LIMIT) { //Metoda 'getRememberedImages', która pobiera zapamiętane zdjęcia
        $offset = ($page - 1) * $limit; //Obliczanie przesunięcia dla zapytania do bazy danych. Działa to w taki sposób, że jeśli mamy 10 zdjęć na stronie, to dla pierwszej strony przesunięcie wynosi 0, dla drugiej 10, dla trzeciej 20 itd.
        $rememberedImages = []; //Inicjalizacja zmiennej $rememberedImages jako pustej tablicy

        if (isset($_SESSION['remembered'])) { //Sprawdzenie czy istnieje zmienna sesyjna 'remembered'
            $totalImages = count($_SESSION['remembered']); //Obliczenie liczby zapamiętanych zdjęć
            $totalPages = ceil($totalImages / $limit); //Obliczenie liczby wszystkich stron z zapamiętanymi zdjęciami
            $rememberedFileNames = array_slice($_SESSION['remembered'], $offset, $limit); //Pobranie zapamiętanych zdjęć dla danej strony. Działa

            foreach ($rememberedFileNames as $fileName) { //Pętla po nazwach plików zapamiętanych zdjęć
                $image = $this->imageModel->getByFileName($fileName); //Pobranie obiektu zdjęcia po nazwie pliku 
                if ($image) { //Sprawdzenie czy obiekt istnieje
                    $rememberedImages[] = [ //Dodanie zdjęcia do tablicy $rememberedImages
                        'thumbnail' => 'images/thumbnail_' . $image->fileName, //Scieżka do miniaturki zdjęcia
                        'watermarked' => 'images/watermarked_' . $image->fileName, //Ścieżka do zdjęcia z znakiem wodnym
                        'checked' => 'checked', //Oznaczenie zdjęcia jako zaznaczone
                        'title' => $image->title, //Tytuł zdjęcia
                        'author' => $image->author, //Autor zdjęcia
                        'fileName' => $image->fileName //Nazwa pliku zdjęcia
                    ];
                }
            }
        } else { //Jeśli zmienna sesyjna 'remembered' nie istnieje, ustawiamy liczbę zapamiętanych zdjęć na 0 i liczbę stron na 1
            $totalImages = 0;
            $totalPages = 1;
        }

        return [ //Zwrócenie tablicy z danymi zapamiętanych zdjęć, liczbą stron i numerem aktualnej strony
            'images' => $rememberedImages,
            'totalPages' => $totalPages,
            'page' => $page
        ];
    }

    public function rememberImages($remembered) { //Metoda 'rememberImages', która zapamiętuje zdjęcia
        if (!isset($_SESSION['remembered'])) { //Sprawdzenie czy istnieje zmienna sesyjna 'remembered'
            $_SESSION['remembered'] = []; //Jeżei nie istnieje, to zainicjalizuj ją jako pustą tablicę
        }
        foreach ($remembered as $fileName) { //Pętla po nazwach plików zapamiętanych zdjęć
            if (!in_array($fileName, $_SESSION['remembered'])) { //Sprawdzenie czy zdjęcie nie jest już zapamiętane
                $_SESSION['remembered'][] = $fileName; //Jeśli nie są, to dodaj je do tablicy 'remembered'
            }
        }
    }

    public function removeRememberedImages($remembered) { //Metoda 'removeRememberedImages', która usuwa zapamiętane zdjęcia
        if (!isset($_SESSION['remembered'])) { //Sprawdzenie czy istnieje zmienna sesyjna 'remembered'
            $_SESSION['remembered'] = []; //Jeśli nie istnieje, to zainicjalizuj ją jako pustą tablicę
        }
        $_SESSION['remembered'] = array_values(array_diff($_SESSION['remembered'], $remembered)); //Usunięcie zdjęć z tablicy 'remembered'. Działa to w taki sposób, że zwracane są tylko zdjęcia, które nie zostały usunięte
    }
}