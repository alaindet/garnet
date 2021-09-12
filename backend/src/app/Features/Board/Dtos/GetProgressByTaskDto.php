<?php

namespace App\Features\Board\Dtos;

use App\Features\Board\Models\TaskProgress;

class GetProgressByTaskDto
{
    /** @var TaskProgress[] */
    public array $tasks;

    public function __construct(TaskProgress ...$tasks)
    {
        $this->tasks = $tasks;
    }
}
