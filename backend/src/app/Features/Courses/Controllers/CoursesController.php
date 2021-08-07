<?php

namespace App\Features\Courses\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Courses\Dtos\CreateCourseDto;
use App\Features\Courses\Services\CoursesService;

class CoursesController extends Controller
{
    private CoursesService $coursesService;

    public function __construct()
    {
        $this->coursesService = new CoursesService();
    }

    public function getAllByTeacher(Request $req, Response $res): Response
    {
        $teacherId = $req->getUriParameter('teacherid');

        $data = $this->coursesService->getAllByTeacherId($teacherId);

        $res->setBody([
            'message' => "All courses of teacher #{$teacherId}",
            'data' => $data,
        ]);

        return $res;
    }
}
