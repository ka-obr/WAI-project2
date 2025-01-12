<?php

namespace App\Services; //deklaracja przestrzeni nazw 'App\Services', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

 class FileValidator { //Definicja klasy 'FileValidator', która będzie walidować pliki
    const ALLOWED_TYPES = ['image/png', 'image/jpeg', 'image/jpg']; //Stała 'ALLOWED_TYPES", która zawiera dowolne typy MIME plików
    const MAX_SIZE = 1 * 1024 * 1024; //Stała 'MAX_SIZE', która zawiera maksymalny rozmiar pliku (1MB)

    public static function validate($fileType, $fileSize) { //Statyczna metoda 'validate', która sprawdza typ i rozmiar pliku
        $errors = []; //Inicjalizacja pustej tablicy $errors do przedstawienia błędów walidacji
        if ($fileSize > self::MAX_SIZE) { //Sprawdzenie czy rozmiar pliku jest większy niż maksymalny rozmiar
            $errors[] = 'Plik jest za duży.'; //Dodanie błędu do tablicy $errors, jeśli plik jest za duży
        }
        if (!in_array($fileType, self::ALLOWED_TYPES)) { //Sprawdzenie czy typ pliku znajduje się w tablicy ALLOWED_TYPES
            $errors[] = 'Niedozwolony format pliku.'; //Dodanie błędu do tablicy $errors, jeśli typ pliku jest niedozwolony
        }
        return $errors; //Zwrócenie tablicy $errors z błędami walidacji
    }
}