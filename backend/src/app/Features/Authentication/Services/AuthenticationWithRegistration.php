<?php

namespace App\Features\Authentication\Services;

use App\Features\Authentication\Dtos\SignedInUserDto;
use App\Features\Authentication\Dtos\RegisterUserDto;
use App\Features\Authentication\Dtos\SignInUserDto;
use App\Features\Users\Repositories\UsersRepository;

trait AuthenticationWithRegistration
{
    public function register(
        RegisterUserDto $registerDto
    ): SignedInUserDto
    {
        $usersRepo = new UsersRepository();
        $plainPassword = $registerDto->password;
        $registerDto->password = password_hash($plainPassword, PASSWORD_BCRYPT);
        $userId = $usersRepo->createUser($registerDto);

        $signInDto = new SignInUserDto();
        $signInDto->email = $registerDto->email;
        $signInDto->password = $registerDto->password;

        return $this->signIn($signInDto);
    }
}
