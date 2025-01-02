<?php

use App\Controllers\GalleryController;

$router = new App\Core\Router();

$router->get('/gallery', 'App\Controllers\GalleryController::index');
$router->get('/upload', 'App\Controllers\GalleryController::upload');
$router->post('/upload', 'App\Controllers\GalleryController::save');
$router->get('/delete', 'App\Controllers\GalleryController::delete');
$router->post('/remember', 'App\Controllers\RememberController::remember');
$router->get('/remembered', 'App\Controllers\RememberController::remembered');
$router->post('/removeRemembered', 'App\Controllers\RememberController::removeRemembered');
$router->get('/resetSession', 'App\Controllers\GalleryController::resetSession');

$router->_404('App\Controllers\ErrorController::_404');