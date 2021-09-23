<?php

namespace App\Features\Authentication\Dtos;

use App\Features\Users\Enums\UserRole;

class RegisterUserDto
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public UserRole $roleId;
}
