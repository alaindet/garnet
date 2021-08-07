<?php

use App\ServiceProvider;

require __DIR__ . '/vendor/autoload.php';

$sp = app_serviceProvider();

$sp->set(\App\Configuration::class, function (ServiceProvider $sp) {
    return new \App\Configuration();
});

$sp->set(\App\DatabaseConnection::class, function (ServiceProvider $sp) {
    $config = $sp->get(\App\Configuration::class);
    return new \App\DatabaseConnection([
        'host' => $config->get('database.host'),
        'database' => $config->get('database.database'),
        'user' => $config->get('database.user'),
        'password' => $config->get('database.password'),
        'port' => $config->get('database.port'),
        'charset' => $config->get('database.charset'),
        'options' => $config->get('database.options'),
    ]);
});

$db = app_serviceProvider(\App\Database::class);
var_dump($dbConn->select('SELECT * FROM courses'));

$sp->set(\App\Database::class, function (ServiceProvider $sp) {
    $dbConn = $sp->get(\App\DatabaseConnection::class);
    return new \App\Database($dbConn);
});