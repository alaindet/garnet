<?php

namespace App\Features\Board\Dtos;

class UpdateTaskState
{
    public string|int $userId;
    public string|int $taskId;
    public string|int $taskStateId;
}
