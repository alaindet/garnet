<?php

namespace App\Core\Services\Database;

use App\Core\Common\Singleton;

class Database
{
    use Singleton;
    use DatabaseConnection;

    public function __construct(array $databaseConfig)
    {
        $this->connect($databaseConfig);
    }
}
