<?php

namespace App\Features\Users;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Users\Controllers\UsersController;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->middleware(AuthenticationMiddleware::class)
            ->handler(UsersController::class)
            ->routes([
                Route::get('/profile', '@getProfile'),
            ])
            ->collect();
    }
}
