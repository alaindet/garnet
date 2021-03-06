<?php

namespace App\Features\Users;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Authentication\Middleware\AuthenticationMiddleware;
use App\Features\Authentication\Middleware\RoleAuthorizationMiddleware;
use App\Features\Users\Middleware\InviteStudentValidationMiddleware;
use App\Features\Users\Middleware\CheckInviteValidationMiddleware;
use App\Features\Users\Middleware\AcceptInviteBySigninInValidationMiddleware;
use App\Features\Users\Middleware\AcceptInviteBySigningUpValidationMiddleware;
use App\Features\Users\Controllers\UsersController;
use App\Features\Users\Enums\UserRole;

class Routes
{
    public static function register(): array
    {
        $role = RoleAuthorizationMiddleware::class;
        $teacher = UserRole::Teacher;

        return (new RouteGroup)
            ->handler(UsersController::class)
            ->routes([

                Route::get('/profile', '@getProfile')
                    ->middleware(AuthenticationMiddleware::class),

                Route::post('/invite/student', '@createStudentInvite')
                    ->middleware(AuthenticationMiddleware::class)
                    ->middleware($role, [$teacher])
                    ->middleware(InviteStudentValidationMiddleware::class),

                // // TODO
                // Route::post('/invite/teacher', '@generateTeacherInvite')

                // Public
                Route::post('/invite/accept/signin', '@acceptInviteBySigningIn')
                    ->middleware(AcceptInviteBySigninInValidationMiddleware::class),

                // Public
                Route::post('/invite/accept/signup', '@acceptInviteBySigningUp')
                    ->middleware(AcceptInviteBySigningUpValidationMiddleware::class),

                // Public
                Route::post('/invite/check', '@checkInviteValidity')
                    ->middleware(CheckInviteValidationMiddleware::class),
            ])
            ->collect();
    }
}
