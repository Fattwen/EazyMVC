# EazyMVC ![Static Badge](https://img.shields.io/badge/php-7.4%5E-blue) ![Static Badge](https://img.shields.io/badge/beta-v1.0.2-orange) ![CI](https://github.com/Fattwen/EazyMVC/actions/workflows/EazyMVC.yml/badge.svg)
基於 [Laravel Eloquent ORM](https://laravel.com/docs/11.x/eloquent)、
[Blade Template](https://laravel.com/docs/11.x/blade#main-content)、
[AltoRouter](https://github.com/dannyvankooten/AltoRouter) 整合而成的MVC框架。

> 使用方法基本與Laravel無異，但是更輕量化，更容易使用，但可能也有更多問題(?)

# 使用方法
- ### 安裝依賴套件
```console
composer install
```
- ### 編寫apache conf(僅供參考)
```apacheconf
<Directory /var/www/html/EazyMVC/public>
        Options FollowSymLinks
        AllowOverride All
</Directory>
```

# 路由 Route
> 沒有那麼強大 但是應該堪用了
- ### 編寫路由
```php
#Routes\Web.php

Route::get('/',function(){
    return "hello world";
});

//或是返回view

Route::get('/',function(){
    return view('welcome');
});

#支援中介層
Route::middleware('demo')->group(function(){  
    #prefix
    Route::prefix('/Demo')->group(function(){
        Route::get('/',[DemoController::class, 'index']);
    });
});

```
- ### 註冊中介層 Middleware
```php
#Routes\Middleware\Middleware.php

private $registerTable = [
        'demo' => \Routes\Middleware\DemoMiddleware::class,
];

```

# 資料庫 Database
> 支援同時多個資料庫來源(connection)
```php
#database.php

$database = [
    //可以新增多個來源 最下面的會是預設DB連線
    'default'=>[
        'driver'    => 'mysql',
        'host'      => env('DB_HOST', '127.0.0.1'),
        'database'  => env('DB_DATABASE'),
        'username'  => env('DB_USERNAME'),
        'password'  => env('DB_PASSWORD'),
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'prefix'    => '',
    ],
];
```
