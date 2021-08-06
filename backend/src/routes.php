<?php

use App\Core\Routing\RouteGroup;
use App\Core\Middleware\CorsMiddleware;
use App\Core\Middleware\AuthenticationMiddleware;
// use App\Features\Todos\Routes as TodosRoutes;
use App\Features\Tests\Routes as TestsRoutes;

$routes = [
    // TodosRoutes::register(),

    // ...
];

// Add test routes
if (!appConfig('env.production')) {
    $routes[] = TestsRoutes::register();
}

$middleware = [
    CorsMiddleware::class,
    [AuthenticationMiddleware::class, ['teacher', 'student']],
    // ...
];

return (new RouteGroup)
    ->middleware($middleware)
    ->routes(...$routes)
    ->collect();
