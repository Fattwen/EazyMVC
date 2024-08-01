<?php
use Routes\Route;
use Routes\Request;
use Jenssegers\Blade\Blade;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

//blade & cahe foleder
define('__viewPath__',__DIR__ . '/Views');
define('__viewCachePath__',__DIR__ . '/Views/cache');
define('__public__',__DIR__ . '/public');
define('__basePath__',str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));

//讀取.env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'support.php';

//定義全域router
global $router;
$router = new AltoRouter();

$requestUri = str_replace(__basePath__, '', $_SERVER['REQUEST_URI']);
$requestUri = '/' . ltrim($requestUri, '/');

//全域view
global $viewer;
$viewer = new Blade(__viewPath__, __viewCachePath__);

require 'database.php';
//model
global $capsule;
$capsule = new Capsule;
$default_db = 'default';
foreach($database as $name => $db)
{
    $default_db = $name;
    $capsule->addConnection($db,$name);
}
$capsule->getDatabaseManager()->setDefaultConnection($default_db);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//路由
require 'Routes/Web.php';

//路由處理
$match = $router->match($requestUri);

if($match)
{
    $routes = Route::getRoutes();

    foreach ($routes as $route) {
        if ($route['method'] == $_SERVER['REQUEST_METHOD'] && $match['target'] === $route['callback']) {
            $middleware = $route['middleware'];
            if ($middleware) {
                $middlewareInstance = new \Routes\Middleware\Middleware($middleware);
                $middlewareInstance->executeMiddleware();
            }

            // 中介層通過或無中介層，繼續處理請求
            if (is_array($match['target']) && is_callable([new $match['target'][0], $match['target'][1]])) {
                $controller = new $match['target'][0];
                $method = $match['target'][1];
                $response = call_user_func_array([$controller, $method], $match['params']);

                if(is_array($response))
                {
                    $response = json_encode($response);
                }
                echo $response;

            } 
            elseif (is_callable($match['target'])) {
                $response = call_user_func_array($match['target'], $match['params']);
                if(is_array($response))
                {
                    $response = json_encode($response);
                }
                echo $response;
            } 

            return;
        }
    }
}
else {
    // 沒有匹配到路由，返回 404 狀態碼
    Route::notFound();
}