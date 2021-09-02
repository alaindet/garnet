<?php

namespace App\Features\Board\Dtos;

class GetBoardTasksRequest
{
    public string|int $courseId;
    public string|int $userId;
}
