<?php

namespace App\Features\Board;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Board\Controllers\BoardController;
use App\Features\Board\Middleware\UpdateTaskStateValidationMiddleware;
use App\Features\Users\Enums\UserRole;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;

class Routes
{
    public static function register(): array
    {
        $role = RoleAuthorizationMiddleware::class;
        $teacher = UserRole::Teacher;

        return (new RouteGroup)
            ->path('/board/{courseid}')
            ->pathConstraints(['courseid' => '\d+', 'taskid' => '\d+'])
            ->middleware(AuthenticationMiddleware::class)
            ->handler(BoardController::class)
            ->routes([
                Route::get('/', '@getTasksByBoard'),
                Route::put('/tasks/{taskid}', '@updateTaskState')
                    ->middleware(UpdateTaskStateValidationMiddleware::class),
                Route::get('/progress/by-student', '@getProgressByStudent')
                    ->middleware($role, [$teacher]),
                Route::get('/progress/by-task', '@getProgressByTask')
                    ->middleware($role, [$teacher]),
            ])
            ->collect();
    }
}
