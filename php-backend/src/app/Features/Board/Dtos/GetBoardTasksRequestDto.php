<?php

namespace App\Features\Board\Dtos;

class GetBoardTasksRequestDto
{
    public string|int $courseId;
    public string|int $userId;
}
