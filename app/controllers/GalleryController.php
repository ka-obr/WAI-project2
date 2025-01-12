<?php

namespace App\Controllers; //deklaracja przestrzeni nazw 'App\Controllers', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Services\GalleryService; // Importowanie klasy 'GalleryService' z przestrzeni nazw 'App\Services'
use App\Models\Image; // Importowanie klasy 'Image' z przestrzeni nazw 'App\Models'

require_once __DIR__ . '/../config/GalleryLimit.php'; //dołączeni pliku konfiguracyjnego z limitem zdjęć 'GalleryLimit.php'

class GalleryController {   //Definicja klasy 'GalleryController', która zawiera metody obsługi galerii zdjęć

    private $galleryService; // Deklaracja prywatnej zmiennej 'galleryService', która przechowuje instancję klasy 'GalleryService'

    public function __construct() { //konstruktor klasy 'GalleryController'
        $this->galleryService = new GalleryService(); //Inicjalizacja zmiennej $galleryService jako nowej instancji klasy 'GalleyService'
    }
    
    public function index() { //Definicja metody 'index', która wyświetla galerię zdjęć
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Pobranie numeru strony z parametru 'page' z adresu URL
        $limit = GALLERY_LIMIT; //Ustawienie limitu zdjęć na stronie zdefiniowanego w pliku konfiguracyjnym 'GalleryLimit.php'

        $data = $this->galleryService->getGalleryImages($page, $limit); //Pobranie danych o zdjęciach z galerii za pomocą metody 'getGalleryImages' z klasy 'GalleryService'

        $preparedImages = $data['images']; // Przygotowanie zdjęć do wyświetlenia
        $totalPages = $data['totalPages']; //Liczba wszystkich stron z zdjęciami
        $page = $data['page']; //Numer aktualnej strony

        require_once __DIR__ . '/../../views/Gallery.php'; // Dołączenie pliku widoku 'Gallery.php', który wyświetla galerię zdjęć
    }

    public function upload() { //Definicja metody 'upload', która wyświetla formularz do przesyłania zdjęć
        include __DIR__ . '/../../views/UploadForm.php'; // Dołączenie pliku widoku 'UploadForm.php', który wyświetla formularz do przesyłania zdjęć
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['watermark'])) { //Sprawdzanie czy żądanie jest typu POST i czy przesłano wszystkie wymagane dane
            $imageModel = new Image(); //inicjalizacja zmiennej $imageModel jako nowej instancji klasy 'Image'
            $result = $imageModel->save($_FILES['image'], $_POST['title'], $_POST['author'], $_POST['watermark']); //Zapisywanie przesłanego zdjęcia za pomocą metody 'save' z klasy 'Image'
    
            if ($result['success']) { //Sprawdzanie czy zapis zdjęcia = sukces
                header('Location: /gallery'); //Przekierowanie na stronę galerii
                exit(); //Zakończenie działania skryptu
            } else {
                $error = $result['error']; //Przypisanie błędu do zmiennej $error
                include __DIR__ . '/../../views/UploadForm.php'; //Dołączenie pliku widoku 'UploadForm.php', który wyświetla formularz do przesyłania zdjęć
            }
        } 
        else {
            include __DIR__ . '/../../views/UploadForm.php'; //Załączenie pliku widoku 'UploadForm.php', który wyświetla formularz do przesyłania zdjęć
        }
    }

    public function delete() { // Definicja metody 'delete', która usuwa zdjęcie z galerii
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fileName'])) { //Sprawdzenie czy żądanie jest typu GET i czy przesłano nazwę pliku
            $fileName = $_GET['fileName']; //Pobranie nazwy pliku z parametru 'fileName' z adresu URL
            $imageModel = new Image(); //Inicjalizacja zmiennej $imageModel jako nowej instancji klasy 'Image'
            $imageModel->delete($fileName); //Usunięcie zdjęcia za pomocą metody 'delete' z klasy 'Image'

            if (isset($_SESSION['remembered'])) { //Sprawdzenie czy istnieje zmienna sesyjna 'remembered'
                $_SESSION['remembered'] = array_filter($_SESSION['remembered'], function($rememberedFileName) use ($fileName) { //Filtrowanie tablicy 'remembered' w celu usunięcia usuniętego zdjęcia
                    return $rememberedFileName !== $fileName; //Zwracanie tylko zdjęć, które nie zostały usunięte
                });
            }

            header('Location: /gallery'); //Przekierowanie na stronę galerii
            exit(); // Zakończenie działania skryptu
        }
    }

    public function resetSession() { //Definicja metody 'resetSession', która resetuje sesję
        session_destroy(); //Zniszczenie sesji, co skutkuje usunięciem wszystkich zmiennych sesyjnych, które zostały ustawione
        header('Location: /gallery'); //Przekierowanie na stronę galerii
        exit(); // Zakończenie działania skryptu
    }
}