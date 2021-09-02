<?php

namespace App\Features\Board;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Board\Controllers\BoardController;
use App\Features\Board\Middleware\UpdateTaskStateValidationMiddleware;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/courses/{courseid}/board')
            ->pathConstraints(['courseid' => '\d+', 'taskid' => '\d+'])
            ->middleware(AuthenticationMiddleware::class)
            ->handler(BoardController::class)
            ->routes([
                Route::get('/', '@getTasksByBoard'),
                Route::put('/tasks/{taskid}', '@updateTaskState')
                    ->middleware(UpdateTaskStateValidationMiddleware::class),
            ])
            ->collect();
    }
}
