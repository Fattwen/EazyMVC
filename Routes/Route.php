<?php
namespace Routes;

use Routes\Middleware\Middleware;

class Route{

    protected static $prefix = '';
    public static $middleware = null;
    protected static $routes = [];

    public static function Router()
    {
        global $router;
        return $router;
    }
    
    public static function map($method, $route, $callback) {

        $route = preg_replace('/\{(\w+)\}/', '[a:$1]', $route);

        $prefixedRoute = rtrim(self::$prefix, '/') . '/' . ltrim($route, '/');

        if($prefixedRoute != '/')
        {
            $prefixedRoute = rtrim($prefixedRoute, '/');
        }

        self::$routes[] = [
            'method' => $method,
            'route' => $prefixedRoute,
            'callback' => $callback,
            'middleware' => self::$middleware,
        ];

        self::Router()->map($method, $prefixedRoute, $callback);
    }

    public static function get($route, $callback) {
        self::map('GET', $route, $callback);
    }

    public static function post($route, $callback) {
        self::map('POST', $route, $callback);
    }

    public static function put($route, $callback) {
        self::map('PUT', $route, $callback);
    }

    public static function patch($route, $callback) {
        self::map('PATCH', $route, $callback);
    }

    public static function delete($route, $callback) {
        self::map('DELETE', $route, $callback);
    }

    public static function prefix($prefix, $callback) {
        $parentPrefix = self::$prefix;
        self::$prefix = rtrim($parentPrefix, '/') . '/' . ltrim($prefix, '/');
        
        $callback();

        self::$prefix = $parentPrefix; // 恢復原來的前綴
    }

    public static function group($callback){
        $callback();
    }

    public static function notFound(){
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo '404 Not Found';
    }

    public static function middleware($middleware) {
        self::$middleware = $middleware;
        return new Middleware($middleware);
    }

    public static function redirect($path)
    {
        $path = "/".ltrim($path,"/");
        header('Location: '.__basePath__.$path);
        exit;
    }

    public static function deny()
    {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }   

    public static function getRoutes() {
        return self::$routes;
    }

}