<?php

namespace App\Features\Courses\Services;

use App\Features\Courses\Dtos\CreateCourseDto;
use App\Features\Courses\Repositories\CoursesRepository;

class CoursesService
{
    private CoursesRepository $coursesRepo;

    public function __construct()
    {
        $this->coursesRepo = new CoursesRepository();
    }

    public function createCourse(CreateCourseDto $dto): int
    {
        return $this->coursesRepo->createCourse($dto);
    }
}
