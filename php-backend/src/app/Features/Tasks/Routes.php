<?php

namespace App\Features\Tasks;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;
use App\Features\Tasks\Controllers\TasksController;
use App\Features\Tasks\Middleware\CreateTaskValidationMiddleware;
use App\Features\Tasks\Middleware\UpdateTaskValidationMiddleware;
use App\Features\Users\Enums\UserRole;

class Routes
{
    public static function register(): array
    {
        $role = RoleAuthorizationMiddleware::class;
        $teacher = UserRole::Teacher;

        return (new RouteGroup)
            ->path('/courses/{courseid}/tasks')
            ->pathConstraints([
                'courseid' => '\d+',
                'taskid' => '\d+',
            ])
            ->middleware(AuthenticationMiddleware::class)
            ->handler(TasksController::class)
            ->routes([

                Route::get('/', '@getAll'),
            
                Route::get('/{taskid}', '@getById'),

                Route::post('/', '@create')
                    ->middleware($role, [$teacher])
                    ->middleware(CreateTaskValidationMiddleware::class),

                Route::patch('/{taskid}', '@update')
                    ->middleware($role, [$teacher])
                    ->middleware(UpdateTaskValidationMiddleware::class),
                
                Route::delete('/{taskid}', '@delete')
                    ->middleware($role, [$teacher]),

            ])
            ->collect();
    }
}
