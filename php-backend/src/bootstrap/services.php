<?php

use App\Core\Services\Configuration\Configuration;
use App\Core\Services\Database\Database;
use App\Core\Services\Database\DatabaseConnection;
use App\Core\Services\ServiceProvider;

$src = dirname(__DIR__);

$sp = ServiceProvider::getInstance();

/**
 * 
 * Configuration
 * 
 */
$sp->set(Configuration::class, function () use ($src) {
    return new Configuration([
        'configDir' => $src . '/config',
        'envDir' => $src,
        'cachePath' => $src . '/cache/config.php',
    ]);
});

/**
 * 
 * Database
 * 
 */
$sp->set(Database::class, function (ServiceProvider $sp) {

    $config = $sp->get(Configuration::class);

    return new Database(
        new DatabaseConnection([
            'host' => $config->get('database.host'),
            'database' => $config->get('database.database'),
            'user' => $config->get('database.user'),
            'password' => $config->get('database.password'),
            'port' => $config->get('database.port'),
            'charset' => $config->get('database.charset'),
            'options' => $config->get('database.options'),
        ])
    );
});