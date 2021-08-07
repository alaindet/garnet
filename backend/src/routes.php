<?php

use App\Core\Routing\RouteGroup;
use App\Core\Middleware\CorsMiddleware;

$routes = [
    \App\Features\Courses\Routes::register(),
    \App\Features\Authentication\Routes::register(),
    // Add route groups here...
];

// Add test routes in development
if (!appConfig('env.production')) {
    $routes[] = \App\Features\Tests\Routes::register();
}

$middleware = [
    CorsMiddleware::class,
    // Add global middleware here...
];

return (new RouteGroup)
    ->middleware($middleware)
    ->routes(array_merge(...$routes))
    ->collect();
