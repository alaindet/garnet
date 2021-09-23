<?php

namespace App\Features\Authentication\Dtos;

class RegisterUserDto
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string | int $roleId;
}
