<?php

namespace App\Features\Authentication\Dtos;

class LoggedUserDto
{
    public string $jwt;
    public string $expireAt;
}
