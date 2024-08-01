<?php
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