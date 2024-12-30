<?php

use App\Controllers\GalleryController;

$router = new App\Core\Router();

$router->get('/MojaStrona/gallery', 'App\Controllers\GalleryController::index');
$router->get('/MojaStrona/upload', 'App\Controllers\GalleryController::upload');
$router->post('/MojaStrona/upload', 'App\Controllers\GalleryController::save');
$router->get('/MojaStrona/delete', 'App\Controllers\GalleryController::delete');
$router->post('/MojaStrona/remember', 'App\Controllers\GalleryController::remember');
$router->get('/MojaStrona/remembered', 'App\Controllers\GalleryController::remembered');
$router->post('/MojaStrona/removeRemembered', 'App\Controllers\GalleryController::removeRemembered');

$router->_404('App\Controllers\ErrorController::_404');