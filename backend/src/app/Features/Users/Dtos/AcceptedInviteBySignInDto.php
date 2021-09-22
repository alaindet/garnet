<?php

namespace App\Features\Users\Dtos;

class AcceptedInviteBySignInDto
{
    public string $jwt;
    public string | int | null $courseId = null;
}
