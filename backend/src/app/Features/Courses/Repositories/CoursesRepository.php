<?php

namespace App\Features\Courses\Repositories;

use App\Core\Services\Database\Database;
use App\Features\Courses\Dtos\CreateCourseDto;

class CoursesRepository
{
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createCourse(CreateCourseDto $dto): int
    {
        // TODO...
        return 3;
    }
}
