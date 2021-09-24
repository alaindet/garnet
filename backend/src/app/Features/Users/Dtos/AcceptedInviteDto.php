<?php

namespace App\Features\Users\Dtos;

class AcceptedInviteDto
{
    public string $jwt;
    public string | int | null $courseId = null;
}
