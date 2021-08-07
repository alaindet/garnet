<?php

namespace App\Features\Tests\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Services\Database\Database;

class TestsController extends Controller
{
    private Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function getAllCourses(Request $req, Response $res, ...$args): Response
    {
        $data = $this->db->rawSelect("SELECT * FROM courses");

        $res->setBody([
            'message' => 'All courses',
            'data' => $data,
        ]);

        return $res;
    }

    public function getStudentsByCourse(
        Request $req,
        Response $res, 
        ...$args
    ): Response
    {
        $uriParams = $req->getUriParameters();
        $courseId = $uriParams['courseId'];

        $sql = "
            SELECT
                u.first_name,
                u.last_name,
                u.email
            FROM
                course_student AS cs
                JOIN users AS u ON cs.student_id = u.user_id
            WHERE
                cs.course_id = :courseid
        ";

        $pdo = $this->db->getPdo();
        $query = $pdo->prepare($sql);
        $query->bindValue(':courseid', $courseId, \PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetchAll();

        $res->setBody([
            'message' => "All students of course {$courseId}",
            'data' => $data,
        ]);

        return $res;
    }
}
