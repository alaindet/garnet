<?php

namespace App\Core\Http;

/**
 * Based on
 * https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 *
 * Only some common HTTP status codes are used
 */
class HttpStatusCode
{
    // 2xx: Successful response
    const Ok = 200;
    const Created = 201;

    // 3xx: Redirect messages
    const MovedPermanently = 301;
    const Found = 302;

    // 4xx: Client error responses
    const BadRequest = 400;
    const Unauthorized = 401;
    const Forbidden = 403;
    const NotFound = 404;
    const MethodNotAllowed = 405;
    const Conflict = 409;
    const TooManyRequests = 429;

    // 5xx: Server error responses
    const InternalServerError = 500;
    const ServiceUnavailable = 503;
}
