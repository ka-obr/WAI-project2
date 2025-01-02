<?php

namespace App\Core;

use MongoDB\Client;

class MongoDatabase {
    private static $instance = null;
    private $client;
    private $database;

    private function __construct() {
        $config = require __DIR__ . '/../config/MongoDataBase.php';
        $this->client = new Client(
            $config['mongo']['uri'],
            [
                'username' => $config['mongo']['username'],
                'password' => $config['mongo']['password'],
            ]
        );
        $this->database = $this->client->selectDatabase($config['mongo']['database']);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClient() {
        return $this->client;
    }

    public function getDatabase() {
        return $this->database;
    }
}