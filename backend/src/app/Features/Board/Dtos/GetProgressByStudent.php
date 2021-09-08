<?php

namespace App\Features\Board\Dtos;

use App\Features\Board\Models\StudentProgress;

class GetProgressByStudent
{
    /** @var StudentProgress[] */
    public array $students;

    public function __construct(StudentProgress ...$students)
    {
        $this->students = $students;
    }
}
