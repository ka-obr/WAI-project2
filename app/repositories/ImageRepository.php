<?php

namespace App\Repositories;

use App\Core\MongoDatabase;

class ImageRepository {
    private $database;

    public function __construct() {
        try {
            $db = MongoDatabase::getInstance();
            $this->database = $db->getDatabase();
        } catch (Exception $e) {
            throw new \RuntimeException('Błąd podczas łączenia z bazą danych: ' . $e->getMessage());
        }
    }

    public function getAll($limit, $offset) {
        $collection = $this->database->images;
        $options = [
            'limit' => $limit,
            'skip' => $offset,
        ];
        $cursor = $collection->find([], $options);
        return $cursor->toArray();
    }

    public function countAll() {
        $collection = $this->database->images;
        return $collection->count();
    }

    public function save($data) {
        $collection = $this->database->images;
        $collection->insertOne($data);
    }

    public function delete($fileName) {
        $collection = $this->database->images;
        $collection->deleteOne(['fileName' => $fileName]);
    }

    public function getByFileName($fileName) {
        $collection = $this->database->images;
        return $collection->findOne(['fileName' => $fileName]);
    }
}