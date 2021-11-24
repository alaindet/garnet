<?php

namespace App\Features\Board\Dtos;

use App\Features\Board\Models\StudentProgress;

class GetProgressByStudentDto
{
    /** @var StudentProgress[] */
    public array $students;

    public function __construct(StudentProgress ...$students)
    {
        $this->students = $students;
    }
}
