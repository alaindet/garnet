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

    public function create(CreateCourseDto $dto): array
    {
        return $this->coursesRepo->create($dto);
    }

    public function getAllByTeacherId(string $teacherId): array
    {
        return $this->coursesRepo->getAllByTeacherId($teacherId);
    }

    public function getAllByStudentId(string $studentId): array
    {
        return $this->coursesRepo->getAllByStudentId($studentId);
    }
}
