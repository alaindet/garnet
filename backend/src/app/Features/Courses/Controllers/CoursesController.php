<?php

namespace App\Features\Courses\Controllers;

use App\Core\Controller;
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

    private function getTeacherCourses(string $teacherId): array
    {
        return [];
    }

    private function getStudentCourses(string $studentId): array
    {
        return [];
    }

    public function getAll(Request $req, Response $res): Response
    {
        $data = null;
        $authData = $req->getAuthenticationData();
        $role = $authData['user_role_id'];

        switch ($role) {
            case UserRolesRepository::TEACHER:
                $teacherId = $req->getQueryParameter('teacherId');
                if ($teacherId === null) {
                    // BAD REQUEST
                }
                // FETCH
                break;
            case UserRolesRepository::STUDENT:
                // ...
                break;
        }

        return $res;
    }
}
