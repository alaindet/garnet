<?php

namespace App\Features\Board\Models;

class BoardTask
{
    public string|int $taskId;
    public string|int $taskStateId;
    public string $createdOn; // Ex.: 2021-08-22 21:25:00.000
    public string $updatedOn; // Ex.: 2021-08-22 21:25:00.000
    public string $name;
    public string $description;
}
