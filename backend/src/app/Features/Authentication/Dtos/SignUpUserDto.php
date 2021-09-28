<?php

namespace App\Features\Authentication\Dtos;

class SignUpUserDto
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public int $roleId; // UserRole
}
