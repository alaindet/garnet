<?php

namespace App\Features\Courses\Dtos;

class UpdatedCourseDto
{
    public string $courseId;
    public string $teacherId;
    public string $createdOn; // Ex.: 2021-08-22 21:25:00.000
    public string $updatedOn; // Ex.: 2021-08-22 21:25:00.000
    public string $name;
    public string|null $description;
}
