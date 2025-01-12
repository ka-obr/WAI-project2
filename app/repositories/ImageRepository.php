<?php

namespace App\Repositories; //Deklaracja przesrzeni nazw 'App\Repositories', która pozwala na orgaznizowanie kodu w logiczne grupy i unikanie konfliktów nazw

use App\Core\MongoDatabase; //Importowanie klasy 'MongoDatabase' z przestrzeni nazw 'App\Core'

class ImageRepository { //Definicja klasy 'ImageRespository', która będzie obsługiwać operacje na obrazach w bazie danych
    private $database; //Deklaracja prywatnej zmiennej $database przechowującej połączenie z bazą danych

    public function __construct() {
        try {
            $db = MongoDatabase::getInstance(); //Pobranie instancji klasy 'MongoDatabase' za pomocą metody 'getInstance'
            $this->database = $db->getDatabase(); //Przypisanie połączenia do bazy danych do zmiennej $database
        } catch (Exception $e) { //Obsługa wyjątków
            throw new \RuntimeException('Błąd podczas łączenia z bazą danych: ' . $e->getMessage()); //Rzucenie wyjątku w przypadku błędu połączenia z bazą danych
        }
    }

    public function getAll($limit, $offset) { //Metoda getAll, która pobiera wszystkie obrazy z limitem i przesunięciem
        $collection = $this->database->images; //Pobranie kolekcji 'images' z bazy danych
        $options = [ //Ustawienie opcji zapytania
            'limit' => $limit, //limit wyników
            'skip' => $offset, //przesunięcie wyników
        ];
        $cursor = $collection->find([], $options); //Wykonanie zapytania do kolekcji 'images' z ustawionymi opcjami
        return $cursor->toArray(); //Zwrócenie wyników zapytania w postaci tablicy
    }

    public function countAll() { //Metoda countAll, która zwraca liczbę wszystkich obrazów
        $collection = $this->database->images; //Pobranie kolekcji 'images' z bazy danych
        return $collection->count(); //Zwrócenie liczby dokumentów w kolekcji 'images'
    }

    public function save($data) { //Metoda save, która zapisuje obraz w bazie danych
        $collection = $this->database->images; //Pobranie kolekcji 'images' z bazy danych
        $collection->insertOne($data); //Wstawienie nowego dokumentu do kolekcji 'images'
    }

    public function delete($fileName) { //Metoda delete, która usuwa obraz z bazy danych
        $collection = $this->database->images; //Pobranie kolekcji 'images' z bazy danych
        $collection->deleteOne(['fileName' => $fileName]); //Usunięcie dokumentu z kolekcji 'images' na podstawie nazwy pliku
    }

    public function getByFileName($fileName) { //Metoda getByFileName, która pobiera obraz z bazy danych na podstawie nazwy pliku
        $collection = $this->database->images; //Pobranie kolekcji 'images' z bazy danych
        return $collection->findOne(['fileName' => $fileName]); //Znalezienie i zwrócenie dokumentu z kolekcji 'images' na podstawie nazwy pliku
    }
}