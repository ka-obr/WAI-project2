<?php

use App\Controllers\GalleryController;

$router = new App\Core\Router();

$router->get('/MojaStrona/gallery', 'App\Controllers\GalleryController::index');
$router->get('/MojaStrona/upload', 'App\Controllers\GalleryController::upload');
$router->post('/MojaStrona/upload', 'App\Controllers\GalleryController::save');
$router->get('/MojaStrona/delete', 'App\Controllers\GalleryController::delete');
$router->post('/MojaStrona/remember', 'App\Controllers\RememberController::remember');
$router->get('/MojaStrona/remembered', 'App\Controllers\RememberController::remembered');
$router->post('/MojaStrona/removeRemembered', 'App\Controllers\RememberController::removeRemembered');
$router->get('/MojaStrona/resetSession', 'App\Controllers\GalleryController::resetSession');

$router->_404('App\Controllers\ErrorController::_404');