<?php

namespace App\Features\Board\Dtos;

class UpdateTaskStateDto
{
    public string|int $userId;
    public string|int $taskId;
    public string|int $taskStateId;
}
