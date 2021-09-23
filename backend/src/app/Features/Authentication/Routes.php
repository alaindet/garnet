<?php

namespace App\Features\Authentication;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Controllers\AuthenticationController;
use App\Features\Authentication\Middleware\SignInValidationMiddleware;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/auth')
            ->handler(AuthenticationController::class)
            ->routes([

                // Public
                Route::post('/signin', '@signIn')
                    ->middleware(SignInValidationMiddleware::class)
            ])
            ->collect();
    }
}
