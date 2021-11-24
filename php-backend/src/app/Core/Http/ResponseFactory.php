<?php

namespace App\Core\Http;

use App\Core\Http\Response\Response;

abstract class ResponseFactory
{
    static public function createResponse(
        int $statusCode = HttpStatusCode::Ok,
        bool $withCors = false
    ): Response
    {
        $res = new Response($statusCode);
        return $withCors ? appResponseWithCors($res) : $res;
    }
}
