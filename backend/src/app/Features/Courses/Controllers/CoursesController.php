<?php

namespace App\Features\Courses\Controllers;

use App\Core\Controller;
use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Users\Enums\UserRole;
use App\Features\Courses\Services\CoursesService;

class CoursesController extends Controller
{
    private CoursesService $coursesService;

    public function __construct()
    {
        $this->coursesService = new CoursesService();
    }

    public function create(Request $req, Response $res): Response
    {
        $dtoIn = $req->getValidatedData('dto');
        $dtoOut = $this->coursesService->create($dtoIn);

        $res->setBody([
            'message' => 'New course created',
            'data' => $dtoOut,
        ]);

        return $res;
    }

    public function getAll(Request $req, Response $res): Response
    {
        $message = '';
        $courses = null;
        $authData = $req->getAuthenticationData();
        $userId = $authData['user_id'];
        $userRoleId = $authData['user_role_id'];

        switch ($userRoleId) {
            case UserRole::Teacher:
                $message = "All courses of teacher #{$userId}";
                $courses = $this->coursesService->getAllByTeacherId($userId);
                break;
            case UserRole::Student:
                $message = "All courses of student #{$userId}";
                $courses = $this->coursesService->getAllByStudentId($userId);
                break;
            default:
                throw new UnauthorizedHttpException('You are not authorized');
        }

        $res->setBody([
            'message' => $message,
            'data' => $courses,
        ]);

        return $res;
    }

    public function getById(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $course = $this->coursesService->findById($courseId);

        $res->setBody([
            'message' => "Get course #{$courseId} data",
            'data' => $course,
        ]);

        return $res;
    }

    public function update(Request $req, Response $res): Response
    {
        $dtoIn = $req->getValidatedData('dto');

        $dtoOut = $this->coursesService->updateById($dtoIn);

        $res->setBody([
            'message' => "Course #{$dtoOut->courseId} updated",
            'data' => $dtoOut,
        ]);

        return $res;
    }

    public function delete(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $dtoOut = $this->coursesService->deleteById($courseId);

        $res->setBody([
            'message' => "Course #{$courseId} deleted",
            'data' => $dtoOut,
        ]);

        return $res;
    }
}
