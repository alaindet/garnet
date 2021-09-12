<?php

namespace App\Features\Board\Models;

class BoardTask
{
    public string|int $taskId;
    public string|int $taskStateId;
    public int $createdOn; // Ex.: 1629419520000
    public int $updatedOn; // Ex.: 1629419520000
    public string $name;
    public string $description;
}
