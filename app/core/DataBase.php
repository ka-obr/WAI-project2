<?php

namespace App\Core; //Deklaracja przestrzeni nazw 'App\Core', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfilktów nazw

use MongoDB\Client; //Importowanie klasy 'Client' z biblioteki MongoDB

class MongoDatabase { //Definicja klasy 'MongoDatabase', która będzie obsługiwać połączenie z bazą danych MongoDB 
    private static $instance = null; //Deklaracja prywatnej statycznej zmiennej 'instance', która przechowuje instancję klasy 'MongoDatabase'
    private $client; //Deklaracja prywatnej zmiennej 'client', która przechowuje instancję klasy 'Client'
    private $database; //Deklaracja prywatnej zmiennej 'database', która przechowuje połączenie z bazą danych

    private function __construct() { //Prywatny konstruktor klasy MongoDatabase, który uniemożliwia tworzenie nowych instancji z zewnątrz
        $config = require __DIR__ . '/../config/MongoDataBase.php'; //Dołączenie pliku konfiguracyjnego 'MongoDataBase.php', który zawiera dane do połączenia z bazą danych i przypisanie jego zawartości do zmiennej $config
        $this->client = new Client( //Inicjalizacja zmiennej $client nową instancją klasy 'Client' z parametrami połączenia z bazą danych
            $config['mongo']['uri'], //Przekazanie URI połączenia do MongoDB
            [
                'username' => $config['mongo']['username'], //Przekazanie nazwy użytkownika do autoryzacji
                'password' => $config['mongo']['password'], //Przekazanie hasła użytkownika do autoryzacji
            ]
        );

        $this->database = $this->client->selectDatabase($config['mongo']['database']); //Wybór bazy danych i przypisanie jej do zmiennej $database

    }

    public static function getInstance() { //Statyczna metoda 'getInstance', która zwraca jedyną instancję klasy MongoDatabase
        if (self::$instance === null) { //Sprawdzenie czy instancja klasy MongoDatabase nie została jeszcze utworzona
            self::$instance = new self(); //Jeśli nie, to utwórz nową instancję klasy MongoDatabase
        }
        return self::$instance; //Zwróć instancję klasy MongoDatabase
    }

    public function getClient() { //Metoda 'getClient', która zwraca instancję klasy 'Client'
        return $this->client; //Zwróć instancję klasy 'Client'
    }

    public function getDatabase() { //Metoda 'getDatabase', która zwraca połączenie z bazą danych
        return $this->database; //Zwróć połączenie z bazą danych
    }
}