<?php

use App\Controllers\GalleryController; // Importowanie klasy 'GalleryController' z przestrzeni nazw 'App\Controllers'

$router = new App\Core\Router(); //Tworzenie nowej instancji klasy 'Router' z przestrzeni nazw 'App\Core'

$router->get('/gallery', 'App\Controllers\GalleryController::index'); //Definiowanie trasy GET '/gallery', która wywołuje metodę 'index' z klasy 'GalleryController'
$router->get('/upload', 'App\Controllers\GalleryController::upload'); //Definiowanie trasy GET '/upload', która wywołuje metodę 'upload' z klasy 'GalleryController'
$router->post('/upload', 'App\Controllers\GalleryController::save'); //Definiowanie trasy POST '/upload', która wywołuje metodę 'save' z klasy 'GalleryController'
$router->get('/delete', 'App\Controllers\GalleryController::delete'); //Definiowanie trasy GET '/delete', która wywołuje metodę 'delete' z klasy 'GalleryController'
$router->post('/remember', 'App\Controllers\RememberController::remember'); //Definiowanie trasy POST '/remember', która wywołuje metodę 'remember' z klasy 'RememberController'
$router->get('/remembered', 'App\Controllers\RememberController::remembered'); //Definiowanie trasy GET '/remembered', która wywołuje metodę 'remembered' z klasy 'RememberController'
$router->post('/removeRemembered', 'App\Controllers\RememberController::removeRemembered'); //Definiowanie trasy POST '/removeRemembered', która wywołuje metodę 'removeRemembered' z klasy 'RememberController'
$router->get('/resetSession', 'App\Controllers\GalleryController::resetSession');  //Definiowanie trasy GET '/resetSession', która wywołuje metodę 'resetSession' z klasy 'GalleryController'

$router->_404('App\Controllers\ErrorController::_404'); //Definiowanie trasy dla błędu 404, która wywołuje metodę '_404' z klasy 'ErrorController'