<?php

namespace App\Features\Courses\Services;

use App\Features\Courses\Repositories\CoursesRepository;
use App\Features\Courses\Dtos\CreateCourseDto;

class CoursesService
{
    private CoursesRepository $coursesRepo;

    public function __construct()
    {
        $this->coursesRepo = new CoursesRepository();
    }

    public function getAllByTeacherId(string $teacherId): array
    {
        return $this->coursesRepo->getAllByTeacherId($teacherId);
    }
}
