<?php

namespace App\Core; //Deklaracja przestrzeni nazw 'App\Core', która pozwala na organizowanie kodu w logiczne grupy i unikanie konfliktów nazw

class Router { //Definicja klasy 'Router', która będzie obsługiwać routing w aplikacji
    private $routes = []; //Deklaracja prywatnej zmiennej $routes, która będzie przechowywać wszystkie zdefiniowane trasy

    public function get($uri, $controller) { //Metoda 'get' która dodaje trasę dla żądań typu GET
        $this->addRoute('GET', $uri, $controller); //Wywołanie metody 'addRoute' z parametrami 'GET', 'uri' i 'controller'
    }

    public function post($uri, $controller) { //Metoda 'post' która dodaje trasę dla żądań typu POST
        $this->addRoute('POST', $uri, $controller); //Wywołanie metody 'addRoute' z parametrami 'POST', 'uri' i 'controller'
    }

    public function _404($controller) { //Metoda '_404' która dodaje trasę dla żądań, które nie pasują do żadnej zdefiniowanej trasy
        $this->routes['404'] = $controller; //Przypisanie kontrollera dla błędu 404 do tablicy $routes
    }

    private function addRoute($method, $uri, $controller) { //Prywatna metoda addRoute, która dodaje trasę do tablicy $routes
        $this->routes[$method][$uri] = $controller; //Przypisanie kontrolera do tablicy $routes dla danego $method i $uri
    }

    public function dispatch($uri, $method) { //Metoda 'dispatch', która obsługuje żądanie na podstawie $uri i $method
        if (isset($this->routes[$method][$uri])) { // Sprawdzenie czy trasa dla danego $method i $uri istnieje
            $controllerAction = explode('::', $this->routes[$method][$uri]); //Rozdzielenie kontrolera i akcji za pomocą '::'
            $controllerName = $controllerAction[0]; //Przypisanie nazwy kontrolera do zmiennej $controllerName
            $action = $controllerAction[1]; //Przypisanie akcji do zmiennej $action

            $controller = new $controllerName(); //Utworzenie nowej instancji kontrolera
            $controller->$action(); //Wywołanie akcji kontrolera
        } 
        else { //Jeśli trasa nie zdefinioawana
            if (isset($this->routes['404'])) { //Sprawdzenie czy zdefiniowano trasę dla błędu 404
                $controllerAction = explode('::', $this->routes['404']); //Rozdzielenie kontrolera i akcji dla błędu 404
                $controllerName = $controllerAction[0]; //Przypisanie nazwy kontrolera do zmiennej $controllerName
                $action = $controllerAction[1]; //Przypisanie akcji do zmiennej $action

                $controller = new $controllerName(); //Utworzenie nowej instancji kontrolera
                $controller->$action(); //Wywołanie akcji kontrolera
            } 
        }
    }
}