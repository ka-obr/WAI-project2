<?php

namespace App\Controllers;

use App\Services\RememberService;

class RememberController {

    private $rememberService;

    public function __construct() {
        $this->rememberService = new RememberService();
    }

    public function remember() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) {
            $this->rememberService->rememberImages($_POST['remember']);
        } else {
            $_SESSION['remembered'] = [];
        }
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        header("Location: /gallery?page=$page");
        exit();
    }

    public function remembered() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = GALLERY_LIMIT;

        $data = $this->rememberService->getRememberedImages($page, $limit);

        $rememberedImages = $data['images'];
        $totalPages = $data['totalPages'];
        $page = $data['page'];

        require_once __DIR__ . '/../../views/Remembered.php';
    }

    public function removeRemembered() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) {
            $this->rememberService->removeRememberedImages($_POST['remember']);
        }
    
        if (!isset($_SESSION['remembered'])) {
            $_SESSION['remembered'] = [];
        }
    
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = GALLERY_LIMIT;
        $totalImages = count($_SESSION['remembered']);
        $totalPages = ceil($totalImages / $limit);
    
        if ($page > $totalPages) {
            $page = $totalPages;
        }
    
        header("Location: /remembered?page=$page");
        exit();
    }
}