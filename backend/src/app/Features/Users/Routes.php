<?php

namespace App\Features\Users;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;
use App\Features\Users\Middleware\InviteStudentValidationMiddleware;
use App\Features\Users\Controllers\UsersController;
use App\Features\Users\Enums\UserRole;

class Routes
{
    public static function register(): array
    {
        $role = RoleAuthorizationMiddleware::class;
        $teacher = UserRole::Teacher;

        return (new RouteGroup)
            ->middleware(AuthenticationMiddleware::class)
            ->handler(UsersController::class)
            ->routes([
                Route::get('/profile', '@getProfile'),
                Route::post('/invite/student', '@generateStudentInvite')
                    ->middleware($role, [$teacher])
                    ->middleware(InviteStudentValidationMiddleware::class),
            ])
            ->collect();
    }
}
