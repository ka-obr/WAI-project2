<?php

namespace App\Controllers; //Delaracja przestrzeni nazw 'App\Controllers', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Services\RememberService; //Importowanie klasy 'RememberService' z przestrzeni nazw 'App\Services'

class RememberController { //Definicja klasy 'RememberController', która będzie zawierać metody do obsługi zapamiętanych zdjęć

    private $rememberService; //Deklaracja prywatnej zmiennej 'rememberService', która przechowuje instancję klasy 'RememberService'

    public function __construct() { //Konstruktor klasy 'RememberController'
        $this->rememberService = new RememberService(); //Inicjalizacja zmiennej $rememberService jako nowej instancji klasy 'RememberService'
    }

    public function remember() { //Metoda remember, która będzie wywołana przy zapamiętywaniu obrazów
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) { //Sprawdzanie czy żądanie jest typu POST i czy przesłano obrazy do zapamiętania
            $this->rememberService->rememberImages($_POST['remember']); //Zapamiętanie obrazów za pomocą metody 'rememberImages' z klasy 'RememberService'
        } else {
            $_SESSION['remembered'] = []; // Inicjalizacja zmiennej sesyjnej 'remembered' jako pustej tablicy
        }
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1; //Pobranie numeru strony z parametru 'page' z żądania POST
        header("Location: /gallery?page=$page"); //Przekierowanie na stronę galerii o odpowiedniej stronie
        exit(); //zakończenie działania skryptu
    }

    public function remembered() { //Metoda 'remembered', która będzie wywoływana przy wyświetlaniu zapamiętanych obrazów
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //pobranie numeru strony z parametru GET 'page', domyślnie ustawiony na 1
        $limit = GALLERY_LIMIT; //Pobranie limitu obrazów na stronę ze stałej 'GALLERY_LIMIT'

        $data = $this->rememberService->getRememberedImages($page, $limit); //Pobranie zapamiętanych obrazów za pomocą metody 'getRememberedImages' z klasy 'RememberService'

        $rememberedImages = $data['images']; //Przypisanie popbranych obrazów do zmiennej $rememberedImages
        $totalPages = $data['totalPages']; //Przypisanie liczby wszystkich stron z obrazami do zmiennej $totalPages
        $page = $data['page']; //Przypisanie numeru aktualnej strony do zmiennej $page

        require_once __DIR__ . '/../../views/Remembered.php'; //Dołączenie pliku widoku 'Remembered.php', który wyświetla zapamiętane obrazy
    }

    public function removeRemembered() { //Metoda 'removeRemembered', która będzie wywoływana przy usuwaniu zapamiętanych obrazów
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) { //Sprawdzanie czy żądanie jest typu POST i czy przesłano dane 'remember', które zawierają obrazy do usunięcia
            $this->rememberService->removeRememberedImages($_POST['remember']); //Usunięcie zapamiętanych obrazów za pomocą metody 'removeRememberedImages' z klasy 'RememberService'
        }
    
        if (!isset($_SESSION['remembered'])) { //Sprawdzenie czy istnieje sesja 'remembered'
            $_SESSION['remembered'] = []; //Jeśli nie, to zainicjalizuj ją jako pustą tablicę
        }
    
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1; //Pobranie numeru strony z parametru POST 'page', domyślnie ustawiony na 1
        $limit = GALLERY_LIMIT; //Ustawienie limitu zdjęć
        $totalImages = count($_SESSION['remembered']); //Pobranie liczby zapamiętanych obrazów
        $totalPages = ceil($totalImages / $limit); //Obliczenie całkowitej liczby stron z obrazami
    
        if ($page > $totalPages) { //Sprawdzenie czy aktualna strona nie przekracza całkowitej liczby storn
            $page = $totalPages; //Jeśli tak, to ustaw numer strony na ostatnią stronę
        }
    
        header("Location: /remembered?page=$page"); //Przekierowanie na stronę zapamiętanych obrazów o odpowiedniej stronie
        exit(); //Zakończenie skryptu
    }
}