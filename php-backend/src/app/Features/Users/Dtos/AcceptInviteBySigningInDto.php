<?php

namespace App\Features\Users\Dtos;

class AcceptInviteBySigningInDto
{
    public string $email;
    public string $password;
    public string $token;
}
