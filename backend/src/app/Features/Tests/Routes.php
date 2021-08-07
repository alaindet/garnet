<?php

namespace App\Features\Tests;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Tests\Controllers\TestsController;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/tests')
            ->pathConstraints([ 'courseId' => '\d+' ])
            ->handler(TestsController::class)
            ->routes([
                Route::get('/', '@index'),
                Route::get('/private', '@authNeeded')
                    ->middleware(AuthenticationMiddleware::class),
            ])
            ->collect();
    }
}
