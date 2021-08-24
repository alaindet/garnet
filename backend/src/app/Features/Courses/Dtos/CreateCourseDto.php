<?php

namespace App\Features\Courses\Dtos;

class CreateCourseDto
{
    public string|int $teacherId;
    public string $name;
    public ?string $description;
}
