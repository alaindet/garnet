<?php

namespace App\Features\Board\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class GetBoardTasksAsStudentMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $studentId = $req->getUriParameter('studentid');

        // TODO: Check if student belongs to course
        // TODO: Check if course belongs to logged teacher
        // TODO
        /*
        SELECT
            cs.course_id,
            cs.student_id,
            c.teacher_id
        FROM
            course_student AS cs
            INNER JOIN courses AS c ON cs.course_id = c.course_id
        WHERE
            cs.course_id = :courseid AND
            cs.student_id = :studentid
        */

        $req->setValidatedData([
            'studentId' => $studentId,
        ]);

        return $res;
    }
}
