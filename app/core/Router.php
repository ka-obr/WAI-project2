<?php

namespace App\Core;

class Router {
    private $routes = [];

    public function get($uri, $controller) {
        $this->addRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller) {
        $this->addRoute('POST', $uri, $controller);
    }

    public function _404($controller) {
        $this->routes['404'] = $controller;
    }

    private function addRoute($method, $uri, $controller) {
        $this->routes[$method][$uri] = $controller;
    }

    public function dispatch($uri, $method) {
        if (isset($this->routes[$method][$uri])) {
            $controllerAction = explode('::', $this->routes[$method][$uri]);
            $controllerName = $controllerAction[0];
            $action = $controllerAction[1];

            $controller = new $controllerName();
            $controller->$action();
        } 
        else {
            if (isset($this->routes['404'])) {
                $controllerAction = explode('::', $this->routes['404']);
                $controllerName = $controllerAction[0];
                $action = $controllerAction[1];

                $controller = new $controllerName();
                $controller->$action();
            } 
        }
    }
}
?>