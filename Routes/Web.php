<?php
/**
 * 定義路由頁面
 * 支援群組路由(前綴)
 * 支援米斗衛兒
 * 支援直接return view
 * 支援直接重導向
 */
use Routes\Route;
use Controllers\{
    DemoController,
};

Route::get('/',function(){
    //Route::redirect('/User');
    return "hello world";
});

Route::middleware('demo')->group(function(){  
    //Demo
    Route::prefix('/Demo',function(){
        Route::get('/',[DemoController::class, 'index']);
    });
});

