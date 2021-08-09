<?php

namespace App\Features\Authentication\Services;

use App\Features\Users\Repositories\UserSessionsRepository;
use App\Features\Users\Repositories\UsersRepository;

class AuthenticationService
{
    use AuthenticationWithSignIn;

    protected UsersRepository $usersRepo;
    protected UserSessionsRepository $userSessionsRepo;

    public function __construct()
    {
        $this->usersRepo = new UsersRepository();
        $this->userSessionsRepo = new UserSessionsRepository();
    }
}
