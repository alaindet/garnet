<?php

namespace App\Features\Users\Dtos;

class AcceptInviteBySignInDto
{
    public string $email;
    public string $password;
    public string $token;
}
