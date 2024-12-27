<?php

namespace App\Core;

class MongoDatabase {
    private static $instance = null;
    private $manager;
    private $database;

    private function __construct() {
        $config = require __DIR__ . '/../config/MongoDataBase.php';
        $this->manager = new \MongoDB\Driver\Manager($config['mongo']['uri']);
        $this->database = $config['mongo']['database'];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getManager() {
        return $this->manager;
    }

    public function getDatabase() {
        return $this->database;
    }
}