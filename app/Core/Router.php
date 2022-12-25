<?php

class Router
{
    public static $routes = [];

    public static function add_get($path, $controller, $function)
    {
        self::$routes[] = [
            "path" => $path,
            "method" => "GET",
            "controller" => $controller,
            "function" => $function,
        ];

    }

    public static function add_post($path, $controller, $function)
    {
        self::$routes[] = [
            "path" => $path,
            "method" => "POST",
            "controller" => $controller,
            "function" => $function,
        ];
    }

    public static function run() {
        $path = '/';
        if (isset($_SERVER['PATH_INFO'])) $path = $_SERVER['PATH_INFO'];
        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            if ($route['path'] == $path && $route['method'] == $method) {
                $controller = new $route['controller'];
                $controller->{$route['function']}();
                return;
            }
        }
        http_response_code(404);
        echo "Not Found";
    }
}