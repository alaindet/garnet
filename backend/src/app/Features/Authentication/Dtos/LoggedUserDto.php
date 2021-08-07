<?php

namespace App\Features\Authentication\Dtos;

class LoggedUserDto
{
    public string $email;
    public string $jwt;
    public int $expireAt;
}
