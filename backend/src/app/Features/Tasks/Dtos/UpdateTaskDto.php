<?php

namespace App\Features\Tasks\Dtos;

class UpdateTaskDto
{
    public string|int $taskId;
    public ?string $name;
    public ?string $description;
}
