<?php

namespace App\Features\Courses\Controllers;

use App\Core\Controller;
use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Courses\Dtos\CreateCourseDto;
use App\Features\Users\Repositories\UserRolesRepository;
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
        $authData = $req->getAuthenticationData();
        $body = $req->getBody();

        $dto = new CreateCourseDto();
        $dto->teacherId = $authData['user_id'];
        $dto->name = $body['name'];
        $dto->description = !empty($body['description'])
            ? $body['description']
            : null;

        $course = $this->coursesService->create($dto);

        $res->setBody([
            'message' => 'New course created',
            'data' => $course,
        ]);

        return $res;
    }

    public function getAll(Request $req, Response $res): Response
    {
        $message = '';
        $data = null;
        $authData = $req->getAuthenticationData();
        $userId = $authData['user_id'];
        $userRoleId = $authData['user_role_id'];

        switch ($userRoleId) {
            case UserRolesRepository::TEACHER:
                $message = "All courses of teacher #{$userId}";
                $data = $this->coursesService->getAllByTeacherId($userId);
                break;
            case UserRolesRepository::STUDENT:
                $message = "All courses of student #{$userId}";
                $data = $this->coursesService->getAllByStudentId($userId);
                break;
            default:
                throw new UnauthorizedHttpException('You are not authorized');
        }

        $res->setBody([
            'message' => $message,
            'data' => $data,
        ]);

        return $res;
    }
}

