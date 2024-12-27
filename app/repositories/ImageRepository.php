<?php

namespace App\Repositories;

use App\Core\MongoDatabase;

class ImageRepository {
    private $manager;
    private $database;

    public function __construct() {
        $db = MongoDatabase::getInstance();
        $this->manager = $db->getManager();
        $this->database = $db->getDatabase();
    }

    public function getAll($limit, $offset) {
        $query = new \MongoDB\Driver\Query([], [
            'limit' => $limit,
            'skip' => $offset,
        ]);
        $cursor = $this->manager->executeQuery("$this->database.images", $query);
        return $cursor->toArray();
    }

    public function countAll() {
        $command = new \MongoDB\Driver\Command(['count' => 'images']);
        $result = $this->manager->executeCommand($this->database, $command);
        return $result->toArray()[0]->n;
    }

    public function save($data) {
        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->insert($data);
        $this->manager->executeBulkWrite("$this->database.images", $bulk);
    }

    public function delete($fileName) {
        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->delete(['fileName' => $fileName]);
        $this->manager->executeBulkWrite("$this->database.images", $bulk);
    }
}