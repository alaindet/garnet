<?php

namespace App\Features\Courses\Dtos;

class AddStudentToCourseDto
{
    public string | int $courseId;
    public string | int $studentId;
}
