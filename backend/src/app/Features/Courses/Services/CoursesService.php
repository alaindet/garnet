<?php

namespace App\Features\Courses\Services;

use App\Core\Exceptions\Http\InternalServerErrorHttpException;
use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Courses\Dtos\CreateCourseDto;
use App\Features\Courses\Dtos\CreatedCourseDto;
use App\Features\Courses\Dtos\UpdateCourseDto;
use App\Features\Courses\Dtos\UpdatedCourseDto;
use App\Features\Courses\Dtos\DeletedCourseDto;
use App\Features\Courses\Repositories\CoursesRepository;
use App\Shared\Utils\Time;

class CoursesService
{
    private CoursesRepository $coursesRepo;

    public function __construct()
    {
        $this->coursesRepo = new CoursesRepository();
    }

    public function create(CreateCourseDto $dtoIn): CreatedCourseDto
    {
        $data = $this->coursesRepo->create($dtoIn);

        $dtoOut = new CreatedCourseDto();
        $dtoOut->courseId = $data['course_id'];
        $dtoOut->teacherId = $data['teacher_id'];
        $dtoOut->createdOn = Time::getTimestamp($data['created_on']);
        $dtoOut->updatedOn = Time::getTimestamp($data['updated_on']);
        $dtoOut->name = $data['name'];
        $dtoOut->description = $data['description'];

        return $dtoOut;
    }

    public function getAllByTeacherId(string|int $teacherId): array
    {
        return $this->coursesRepo->getAllByTeacherId($teacherId);
    }

    public function getAllByStudentId(string|int $studentId): array
    {
        return $this->coursesRepo->getAllByStudentId($studentId);
    }

    public function findById(string|int $courseId): array
    {
        $course = $this->coursesRepo->findById($courseId);

        if ($course === null) {
            $message = "Course with id #{$courseId} does not exist";
            throw new NotFoundHttpException($message);
        }

        return $course;
    }

    public function existsById(string|int $courseId): bool 
    {
        return $this->coursesRepo->existsById($courseId);   
    }

    public function updateById(UpdateCourseDto $dtoIn): UpdatedCourseDto
    {
        $course = $this->findById($dtoIn->courseId);

        $fields = [];

        if (isset($dtoIn->name)) {
            $fields['name'] = $dtoIn->name;
            $course['name'] = $dtoIn->name;
        }

        if (isset($dtoIn->description)) {
            $fields['description'] = $dtoIn->description;
            $course['description'] = $dtoIn->description;
        }

        $updated = $this->coursesRepo->updateById($dtoIn->courseId, $fields);

        if ($updated === 0) {
            $message = "Could not update course with id #{$dtoIn->courseId}";
            throw new InternalServerErrorHttpException($message);
        }

        $dtoOut = new UpdatedCourseDto();
        $dtoOut->courseId = $course['course_id'];
        $dtoOut->teacherId = $course['teacher_id'];
        $dtoOut->createdOn = Time::getTimestamp($course['created_on']);
        $dtoOut->updatedOn = Time::getTimestamp($course['updated_on']);
        $dtoOut->name = $course['name'];
        $dtoOut->description = $course['description'];

        return $dtoOut;
    }

    public function deleteById(string|int $courseId): DeletedCourseDto
    {
        $course = $this->findById($courseId);

        $deleted = $this->coursesRepo->deleteById($courseId);

        if ($deleted === 0) {
            $message = "Could not update course with id #{$courseId}";
            throw new InternalServerErrorHttpException($message);
        }

        $dtoOut = new DeletedCourseDto();
        $dtoOut->courseId = $course['course_id'];
        $dtoOut->teacherId = $course['teacher_id'];
        $dtoOut->createdOn = Time::getTimestamp($course['created_on']);
        $dtoOut->updatedOn = Time::getTimestamp($course['updated_on']);
        $dtoOut->name = $course['name'];
        $dtoOut->description = $course['description'];

        return $dtoOut;
    }
}
