<?php

namespace App\Features\Courses\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class CoursesRepository extends Repository
{
    use CoursesRepositoryWriteOperations;
    use CoursesRepositoryReadOperations;

    public string $table = 'courses';

    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }
}
