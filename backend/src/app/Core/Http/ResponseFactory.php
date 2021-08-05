<?php

namespace App\Core\Http;

use App\Core\Http\Response\Response;

abstract class ResponseFactory
{
    static public function createResponse(
        int $statusCode = HttpStatusCode::Ok
    ): Response
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        return $response;
    }
}
