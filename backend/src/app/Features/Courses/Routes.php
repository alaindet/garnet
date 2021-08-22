<?php

namespace App\Features\Courses;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;
use App\Features\Courses\Controllers\CoursesController;
use App\Features\Courses\Middleware\CreateCourseValidationMiddleware;
use App\Features\Courses\Middleware\UpdateCourseValidationMiddleware;
use App\Features\Users\Enums\UserRole;

class Routes
{
    public static function register(): array
    {
        $role = RoleAuthorizationMiddleware::class;
        $teacher = UserRole::Teacher;

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

                Route::get('/{id}', '@getById'),

                Route::post('/', '@create')
                    ->middleware($role, [$teacher])
                    ->middleware(CreateCourseValidationMiddleware::class),

                Route::patch('/{id}', '@update')
                    ->middleware($role, [$teacher])
                    ->middleware(UpdateCourseValidationMiddleware::class),
                    
                Route::delete('/{id}', '@delete')
                    ->middleware($role, [$teacher]),
            ])
            ->collect();
    }
}
