<?php

use Dotenv\Dotenv;

use App\Core\Services\Configuration\Configuration;
use App\Core\Services\Database\Database;

$src = dirname(__DIR__);

(Dotenv::createImmutable($src))->load();

$config = Configuration::getInstance([
    'configDir' => $src . '/config',
    'cachePath' => $src . '/cache/config.php',
]);

Database::getInstance([
    'host' => $config->get('database.host'),
    'database' => $config->get('database.database'),
    'charset' => $config->get('database.charset'),
    'port' => $config->get('database.port'),
    'user' => $config->get('database.user'),
    'password' => $config->get('database.password'),
    'options' => $config->get('database.options'),
]);
