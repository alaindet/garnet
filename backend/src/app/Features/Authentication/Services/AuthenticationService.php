<?php

namespace App\Features\Authentication\Services;

use App\Features\Users\Repositories\UsersRepository;

class AuthenticationService
{
    use AuthenticationWithSignIn;

    protected UsersRepository $usersRepo;

    public function __construct()
    {
        $this->usersRepo = new UsersRepository;
    }
}