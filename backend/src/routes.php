<?php

use App\Core\Routing\RouteGroup;
use App\Core\Middleware\CorsMiddleware;

$routes = [
    \App\Features\Authentication\Routes::register(),
    \App\Features\Courses\Routes::register(),
    \App\Features\Tasks\Routes::register(),
    // Add route groups from feature modules here...
];

// Add test routes in development only
if (!appConfig('env.production')) {
    $routes[] = \App\Features\Tests\Routes::register();
}

$middleware = [
    CorsMiddleware::class,
    // Add global middleware here...
];

return (new RouteGroup)
    ->setMiddleware($middleware)
    ->routes(array_merge(...$routes))
    ->collect();
