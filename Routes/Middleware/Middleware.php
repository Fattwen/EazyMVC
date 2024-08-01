<?php
namespace Routes\Middleware;
use Routes\Route;

class Middleware {
    
    protected $middleware;

    //註冊表 mapping middleware名稱 及 實際處理的class
    private $registerTable = [
        'demo' => \Routes\Middleware\DemoMiddleware::class,
    ];


    public function __construct($middleware) {
        $this->middleware = $middleware;
        //$this->executeMiddleware();
    }

    public function executeMiddleware() {
        if (isset($this->registerTable[$this->middleware])) {
            $middlewareClass = $this->registerTable[$this->middleware];
            $middlewareInstance = new $middlewareClass();
            return $middlewareInstance->handle();
        }
    }

    public function group($callback){

        $previousMiddleware = Route::$middleware;
        Route::$middleware = $this->middleware;
        
        $callback();

        Route::$middleware = $previousMiddleware;
        
    }

}