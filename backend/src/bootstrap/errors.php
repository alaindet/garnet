<?php

use App\Core\Exceptions\HttpException;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\ResponseEmitter;
use App\Core\Http\ResponseFactory;

// Convert errors into exceptions
set_error_handler(
    function ($severity, $message, $file, $line) {
        throw new \ErrorException($message, $severity, $severity, $file, $line);
    }
);

// // Handle exceptions
// set_exception_handler(function (\Exception $e) {

//     // Initialize generic 500 error
//     $statusCode = HttpStatusCode::InternalServerError;
//     $response = ResponseFactory::createResponse($statusCode);

//     // Proper HttpException
//     if ($e instanceof HttpException) {
//         $response->setStatusCode($e->getStatusCode());
//         $response->setBody([
//             'error' => true,
//             'message' => $e->getMessage(),
//         ]);
//     }

//     // Production: Generic exception
//     else if (appConfig('env.production')) {
//         $response->setBody([
//             'error' => true,
//             'message' => 'An error occurred',
//         ]);
//     }

//     // Development: Generic exception
//     else {
//         $response->setBody([
//             'error' => true,
//             'message' => $e->getMessage(),
//             'file' => $e->getFile(),
//             'line' => $e->getLine(),
//             'trace' => $e->getTrace(),
//         ]);
//     }

//     ResponseEmitter::send($response);
// });
