<?php

namespace App\Features\Users\Dtos;

use App\Features\Users\Enums\UserRole;

class CreatedStudentInviteDto
{
    public string|int $inviteId;
    public string $token;
    public string $email;
    public string $expiresOn;
    public int $userRoleId = UserRole::Student;
    public string|int $courseId;
}
