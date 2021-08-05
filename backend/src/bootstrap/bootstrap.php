<?php

use Dotenv\Dotenv;

use App\Core\Http\ResponseEmitter;
use App\Core\Routing\Dispatcher;
use App\Core\Routing\Router\Router;
use App\Core\Http\RequestFactory\RequestFactory;
use App\Core\Services\Configuration\Configuration;

define('APP_DIR_SRC', dirname(__DIR__));

require APP_DIR_SRC . '/vendor/autoload.php';

// Load environment variablespathConstraints
(Dotenv::createImmutable(APP_DIR_SRC))->load();

// Load error handling
require __DIR__ . '/errors.php';

// Load configuration
Configuration::getInstance([
    'configDir' => APP_DIR_SRC . '/config',
    'cachePath' => APP_DIR_SRC . '/cache/config.php',
]);

// Create server request
$request = RequestFactory::createsServerRequestFromGlobals();

// Load routes
$routes = require_once APP_DIR_SRC . '/routes.php';

// // Match request with routes
$routeInfo = (new Router($routes))->match($request);

// Build a response
$response = (new Dispatcher($request, $routeInfo))->dispatch();

// Send response to client
ResponseEmitter::send($response);