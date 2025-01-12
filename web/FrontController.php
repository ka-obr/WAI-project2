<?php

namespace App; //deklaracja przestrzeni nazw 'App', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktow nazw

session_start(); //rozpoczęcie nowej sesji lub zwolnienie istniejącej sesji. Sesje są używane do przechowywania informacji o użytkowniku pomiędzy różnymi żądaniami HTTP 

if (!isset($_COOKIE['user_session'])) { //sprawdzanie czy ciasteczko 'user_session' nie jest ustawione. Ciasteczka są używane do przechowywania danych po stronie klienta
    setcookie('user_session', session_id(), time() - 3600, "/"); //Ustawienie ciasteczka 'user_session' z aktualnym ID sesji i czasem wygaśnięcia w przeszłości (efektywnie usuwając je)
}

require_once __DIR__ . '/../vendor/autoload.php'; //dołączenie autoloadera Composer'a, który automatycznie ładuje klasy zainstalowane przez Composer. __DIR__ zwraca ścieżkę do bierzącego katalogu
require_once __DIR__ . '/../app/Autoload.php'; //dołączenie Autoloadera aplikacji, który automatycznie ładuje klasy zdefiniowane w aplikacji
require_once __DIR__ . '/../routes/Routes.php'; //dołączenie pliku z trasami aplikacji, który definiuje dostępne trasy i ich obsługę
                      
//                      zwraca pełne żądanie URI|stała mówiąca, że chcemy uzyswać tylko ścieżkę URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //Parsowanie URI żądania w celu uzyskania ścieżki. $_SERVER['REQUEST_URI'] zawiera pełne URI żądania
$requestMethod = $_SERVER['REQUEST_METHOD']; //Pobranie metody żądania (np. GET, POST). $_SERVER['REQUEST_METHOD'] zawiera metodę HTTP używaną do żądania
$router->dispatch($requestUri, $requestMethod); //Przekazywanie żądania do odpowiedniego handlera trasy za pomocą obiektu $router. $router->dispatch() obsługuje żądanie na podstawie ścieżki i metody