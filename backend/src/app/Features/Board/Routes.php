<?php

namespace App\Features\Tasks;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Board\Controllers\BoardController;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/courses/{courseid}/board')
            ->pathConstraints([
                'courseid' => '\d+',
                'taskid' => '\d+',
            ])
            ->middleware(AuthenticationMiddleware::class)
            ->handler(BoardController::class)
            ->routes([

                Route::get('/', '@getTasksByBoard'),

                Route::put('/{taskid}', '@updateTaskState'),

            ])
            ->collect();
    }
}
