<?php

use App\Core\Routing\Dispatcher;
use App\Core\Routing\Router\Router;
use App\Core\Http\RequestFactory\RequestFactory;
use App\Core\Http\ResponseEmitter;

require dirname(__DIR__) . '/vendor/autoload.php';

require __DIR__ . '/errors.php';
require __DIR__ . '/services.php';
require __DIR__ . '/options-request.php';

$request = RequestFactory::createsServerRequestFromGlobals();

$routes = require_once dirname(__DIR__) . '/routes.php';
$routeInfo = (new Router($routes))->match($request);

$response = (new Dispatcher($request, $routeInfo))->dispatch();
ResponseEmitter::send($response);