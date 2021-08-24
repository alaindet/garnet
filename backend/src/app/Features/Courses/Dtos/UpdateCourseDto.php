<?php

namespace App\Features\Courses\Dtos;

class UpdateCourseDto
{
    public string|int $courseId;
    public ?string $name;
    public ?string $description;
}
