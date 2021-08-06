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

    public function create(Request $req, Response $res): Response
    {
        $dto = new CreateCourseDto();
        $dto->teacherId = 1; // TODO
        $dto->name = 'Just another course'; // TODO
        $courseId = $this->coursesService->createCourse($dto);

        // TODO...
        $data = [
            'id' => $courseId,
        ];

        $res->setStatusCode(201)->setBody([
            'data' => $data,
        ]);


        return $res;
    }

    // public function getAllCourses(Request $req, Response $res, ...$args): Response
    // {
    //     $sql = "SELECT * FROM courses";

    //     $pdo = $this->db->getConnection();
    //     $query = $pdo->prepare($sql);
    //     $query->execute();
    //     $data = $query->fetchAll();

    //     $res->setBody([
    //         'message' => 'All courses',
    //         'data' => $data,
    //     ]);

    //     return $res;
    // }

    // public function getStudentsByCourse(Request $req, Response $res, ...$args): Response
    // {
    //     $uriParams = $req->getUriParameters();
    //     $courseId = $uriParams['courseId'];

    //     $sql = "
    //         SELECT
    //             u.first_name,
    //             u.last_name,
    //             u.email
    //         FROM
    //             course_student AS cs
    //             JOIN users AS u ON cs.student_id = u.user_id
    //         WHERE
    //             cs.course_id = :courseid
    //     ";

    //     $pdo = $this->db->getConnection();
    //     $query = $pdo->prepare($sql);
    //     $query->bindValue(':courseid', $courseId, \PDO::PARAM_INT);
    //     $query->execute();
    //     $data = $query->fetchAll();

    //     $res->setBody([
    //         'message' => "All students of course {$courseId}",
    //         'data' => $data,
    //     ]);

    //     return $res;
    // }
}
