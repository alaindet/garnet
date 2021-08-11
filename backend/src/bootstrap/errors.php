<?php

use App\Core\Exceptions\Http\HttpException;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\ResponseEmitter;
use App\Core\Http\ResponseFactory;

// Convert errors into exceptions
set_error_handler(
    function ($severity, $message, $file, $line)
    {
        throw new \ErrorException($message, $severity, $severity, $file, $line);
    }
);

// Handle exceptions
set_exception_handler(
    function ($e)
    {
        // Initialize generic 500 HTTP error
        $statusCode = HttpStatusCode::InternalServerError;
        $res = ResponseFactory::createResponse($statusCode, $withCors = true);

        // Proper HTTP error
        if ($e instanceof HttpException) {
            $res->setStatusCode($e->getStatusCode());
            $res->setBody([
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ]);
            ResponseEmitter::send($res);
            return;
        }

        // Production: Generic exception
        $errorResponseBody = [
            'error' => [
                'message' => 'An error occurred',
            ],
        ];

        // Development: Generic exception with details
        if (!appConfig('env.production')) {
            $errorResponseBody = [
                'error' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                ],
            ];
        }

        $res->setBody($errorResponseBody);

        ResponseEmitter::send($res);
    }
);
