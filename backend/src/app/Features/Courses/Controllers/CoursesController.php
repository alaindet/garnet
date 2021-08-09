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

    public function getAll(Request $req, Response $res): Response
    {
        dd($req->getAuthenticationData());

        if ($req->hasQueryParameter('teacherId')) {
            // Check if GET param "teacherId" is present and if current user is a teacher and that teacher specifically
        }

        if ($req->hasQueryParameter('studentId')) {
            // Check if GET param "studentId" is present and if current user is a student and that student specifically
        }

        // Perform query

        $teacherId = $req->getUriParameter('teacherid');

        $data = $this->coursesService->getAllByTeacherId($teacherId);

        $res->setBody([
            'message' => "All courses of teacher #{$teacherId}",
            'data' => $data,
        ]);

        return $res;
    }
}
