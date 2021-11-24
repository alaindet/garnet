<?php

namespace App\Features\Board\Models;

class TaskProgress
{
    public string|int $taskId;
    public string $taskName;
    public string $taskDescription;
    public int $studentsToDo;
    public int $studentsInProgress;
    public int $studentsDone;
}
