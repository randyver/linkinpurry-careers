<?php

class Router
{
    protected $routes = [];

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }
    
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $controllerAction = explode('@', $this->routes[$method][$uri]);
            $controllerName = $controllerAction[0];
            $action = $controllerAction[1];

            require_once __DIR__ . '/../controllers/' . $controllerName . '.php';

            $controller = new $controllerName();
            $controller->$action();
        } else {
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}