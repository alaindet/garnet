<?php

namespace App\Features\Users\Dtos;

class GetUserProfileDto
{
    public string|int $userId;
    public int $createdOn; // Ex.: 1629419520000
    public string $firstName;
    public string $lastName;
    public string $role;
    public string $email;
}
