<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\FileValidator;
use App\Services\ImageProcessor;
use App\Core\MongoDatabase;

class Image {
    private static $uploadDir = __DIR__ . '/../../images/';

    public static function getAll($limit = 2, $offset = 0) {
        $db = MongoDatabase::getInstance();
        $manager = $db->getManager();
        $database = $db->getDatabase();

        $query = new \MongoDB\Driver\Query([], [
            'limit' => $limit,
            'skip' => $offset,
        ]);
        $cursor = $manager->executeQuery("$database.images", $query);
        return $cursor->toArray();
    }

    public static function countAll() {
        $db = MongoDatabase::getInstance();
        $manager = $db->getManager();
        $database = $db->getDatabase();

        $command = new \MongoDB\Driver\Command(['count' => 'images']);
        $result = $manager->executeCommand($database, $command);
        return $result->toArray()[0]->n;
    }

    public static function save($file, $title, $author, $watermark) {
        $fileName = basename($file['name']);
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];
        $target = self::$uploadDir . $fileName;

        $errors = FileValidator::validate($fileType, $fileSize);
        if (!empty($errors)) {
            return ['success' => false, 'error' => implode(' ', $errors)];
        }

        if (move_uploaded_file($file['tmp_name'], $target)) {
            ImageProcessor::process($target, $fileName, $watermark);

            $db = MongoDatabase::getInstance();
            $manager = $db->getManager();
            $database = $db->getDatabase();

            $bulk = new \MongoDB\Driver\BulkWrite;
            $bulk->insert([
                'fileName' => $fileName,
                'title' => $title,
                'author' => $author,
                'watermark' => $watermark,
                'created_at' => new \MongoDB\BSON\UTCDateTime(),
            ]);
            $manager->executeBulkWrite("$database.images", $bulk);

            return ['success' => true];
        } 
        else {
            return ['success' => false, 'error' => 'Nie udało się przesłać pliku.'];
        }
    }

    public static function delete($fileName) {
        $db = MongoDatabase::getInstance();
        $manager = $db->getManager();
        $database = $db->getDatabase();

        $thumbnailPath = self::$uploadDir . 'thumbnail_' . $fileName;
        $watermarkedPath = self::$uploadDir . 'watermarked_' . $fileName;
        $originalPath = self::$uploadDir . $fileName;

        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
        if (file_exists($watermarkedPath)) {
            unlink($watermarkedPath);
        }
        if (file_exists($originalPath)) {
            unlink($originalPath);
        }

        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->delete(['fileName' => $fileName]);
        $manager->executeBulkWrite("$database.images", $bulk);
    }
}