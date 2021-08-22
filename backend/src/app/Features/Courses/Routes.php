<?php

namespace App\Features\Courses;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;
use App\Features\Courses\Controllers\CoursesController;
use App\Features\Courses\Middleware\CreateCourseValidationMiddleware;
use App\Features\Users\Enums\UserRole;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/courses')
            ->pathConstraints([
                'teacherid' => '\d+',
                'studentId' => '\d+',
            ])
            ->middleware(AuthenticationMiddleware::class)
            ->handler(CoursesController::class)
            ->routes([
                Route::get('/', '@getAll'),
                Route::post('/', '@create')
                    ->middleware(
                        RoleAuthorizationMiddleware::class,
                        [UserRole::Teacher]
                    )
                    ->middleware(CreateCourseValidationMiddleware::class),
                // Route::get('/{id}', '@getById'),
                // Route::patch('/{id}', '@update'),
                // Route::delete('/{id}', '@delete'),
            ])
            ->collect();
    }
}
