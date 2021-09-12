<?php

namespace App\Features\Tasks\Dtos;

class CreatedTaskDto
{
    public string|int $taskId;
    public string|int $courseId;
    public int $createdOn; // Ex.: 1629419520000
    public int $updatedOn; // Ex.: 1629419520000
    public string $name;
    public string|null $description;
}
