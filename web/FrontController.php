<?php

namespace App;

session_start();

if (!isset($_COOKIE['user_session'])) {
    setcookie('user_session', session_id(), time() - 3600, "/");
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Autoload.php';
require_once __DIR__ . '/../routes/Routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$router->dispatch($requestUri, $requestMethod);