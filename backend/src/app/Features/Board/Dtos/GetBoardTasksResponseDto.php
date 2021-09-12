<?php

namespace App\Features\Board\Dtos;

use App\Features\Board\Models\BoardTask;

class GetBoardTasksResponseDto
{
    /** @var BoardTask[] */
    public array $tasks;

    public function __construct(BoardTask ...$tasks)
    {
        $this->tasks = $tasks;
    }
}
