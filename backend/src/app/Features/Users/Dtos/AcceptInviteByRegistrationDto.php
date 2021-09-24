<?php

namespace App\Features\Users\Dtos;

class AcceptInviteByRegistrationDto
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $token;
}
