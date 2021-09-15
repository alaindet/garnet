<?php

namespace App\Features\Users\Dtos;

use App\Features\Users\Enums\UserRole;

class CreateStudentInviteDto
{
    public string $token;
    public string $email;
    public int $userRoleId = UserRole::Student;
    public string|int $courseId;
}
