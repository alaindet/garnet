<?php

use App\Core\Exceptions\HttpException;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\ResponseEmitter;
use App\Core\Http\ResponseFactory;

function exceptionHandler(\Exception $exception): void
{
    // Initialize generic 500 error
    $statusCode = HttpStatusCode::InternalServerError;
    $response = ResponseFactory::createResponse($statusCode);

    // Proper HttpException
    if ($exception instanceof HttpException) {
        $response->setStatusCode($exception->getStatusCode());
        $response->setBody([
            'error' => true,
            'message' => $exception->getMessage(),
        ]);
    }

    // Production: Generic exception
    elseif (appConfig('env.production')) {
        $response->setBody([
            'error' => true,
            'message' => 'An error occurred',
        ]);
    }

    // Development: Generic exception
    else {
        $response->setBody([
            'error' => true,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ]);
    }

    ResponseEmitter::send($response);
}
