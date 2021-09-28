<?php

namespace App\Features\Authentication\Services;

use App\Features\Authentication\Dtos\SignedInUserDto;
use App\Features\Authentication\Dtos\SignUpUserDto;
use App\Features\Authentication\Dtos\SignInUserDto;
use App\Features\Users\Repositories\UsersRepository;

trait AuthenticationWithSignUp
{
    public function signUp(
        SignUpUserDto $signUpDto
    ): SignedInUserDto
    {
        $usersRepo = new UsersRepository();
        $plainPassword = $signUpDto->password;
        $signUpDto->password = password_hash($plainPassword, PASSWORD_BCRYPT);
        $userId = $usersRepo->createUser($signUpDto);

        $signInDto = new SignInUserDto();
        $signInDto->email = $signUpDto->email;
        $signInDto->password = $signUpDto->password;

        return $this->signIn($signInDto);
    }
}
