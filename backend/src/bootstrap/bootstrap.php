<?php

use Dotenv\Dotenv;

define('GARNET_DIR_SRC', dirname(__DIR__));

require GARNET_DIR_SRC . '/vendor/autoload.php';

require __DIR__ . '/errors.php';

$PATHS = [
    'env' => GARNET_DIR_SRC,
    'cache' => GARNET_DIR_SRC . '/cache',
    'config' => GARNET_DIR_SRC . '/config',
    'routes' => GARNET_DIR_SRC . '/routes.php',
];

(Dotenv::createImmutable($PATHS['env']))->load();

header("Access-Control-Allow-Origin: *");

echo json_encode([
    'message' => 'Hello World',
]);

// Initialize configuration
// Create request
// Import routes
// Match route
// Dispatch route
// Emit response
