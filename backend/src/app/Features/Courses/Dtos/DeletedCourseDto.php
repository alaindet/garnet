<?php

namespace App\Features\Courses\Dtos;

class DeletedCourseDto
{
    public string|int $courseId;
    public string|int $teacherId;
    public int $createdOn; // Ex.: 1629419520000
    public int $updatedOn; // Ex.: 1629419520000
    public string $name;
    public string|null $description;
}
