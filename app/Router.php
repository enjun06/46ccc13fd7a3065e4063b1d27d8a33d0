<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($method, $route, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'action' => $action
        ];
    }

    public function dispatch($uri, $method, $param = null)
    {
        foreach ($this->routes as $route) {
            $routePattern = preg_replace('/{[^}]+}/', '([^/]+)', $route['route']);
            if (preg_match("#^{$routePattern}$#", $uri, $matches) && $route['method'] === $method) {
                array_shift($matches);
                $action = explode('@', $route['action']);
                $controller = "App\\Controllers\\" . $action[0];
                $method = $action[1];

                return (new $controller())->$method($param);
            }
        }

        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Endpoint not found']);
    }
}
