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

    // Fungsi untuk menangani URI dinamis
    public function matchDynamicRoute($uri, $method)
    {
        foreach ($this->routes[$method] as $route => $controller) {
            // Ubah {param} menjadi ekspresi reguler
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            // Cek apakah URI sesuai dengan pola
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Hapus elemen pertama (karena itu seluruh match)

                // Kembalikan controller dan parameter yang cocok
                return [
                    'controller' => $controller,
                    'params' => $matches
                ];
            }
        }
        return false;
    }

    // Fungsi dispatch
    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);

        // Cek apakah rute statis cocok
        if (isset($this->routes[$method][$uri])) {
            $controllerAction = explode('@', $this->routes[$method][$uri]);
            $controllerName = $controllerAction[0];
            $action = $controllerAction[1];

            require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
            $controller = new $controllerName();
            $controller->$action();
        } else {
            // Jika tidak ada rute statis yang cocok, cek rute dinamis
            $dynamicRoute = $this->matchDynamicRoute($uri, $method);
            if ($dynamicRoute) {
                $controllerAction = explode('@', $dynamicRoute['controller']);
                $controllerName = $controllerAction[0];
                $action = $controllerAction[1];

                require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
                $controller = new $controllerName();
                
                // Panggil action dengan parameter dinamis
                call_user_func_array([$controller, $action], $dynamicRoute['params']);
            } else {
                http_response_code(404);
                header('Location: /404');
            }
        }
    }
}
