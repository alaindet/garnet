<?php

namespace App\Features\Board\Models;

class StudentProgress
{
    public string|int $userId;
    public string $firstName;
    public string $lastName;
    public int $tasksToDo;
    public int $tasksInProgress;
    public int $tasksDone;
}
