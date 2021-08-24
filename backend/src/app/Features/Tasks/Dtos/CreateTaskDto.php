<?php

namespace App\Features\Tasks\Dtos;

class CreateTaskDto
{
    public string|int $courseId;
    public string $name;
    public ?string $description;
}
