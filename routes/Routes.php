<?php

use App\Controllers\GalleryController;

$router = new App\Core\Router();

$router->get('/MojaStrona/gallery', 'App\Controllers\GalleryController::index');
$router->get('/MojaStrona/upload', 'App\Controllers\GalleryController::upload');
$router->post('/MojaStrona/upload', 'App\Controllers\GalleryController::save');

$router->_404('App\Controllers\ErrorController::_404');