<?php

namespace App\Core\Http\RequestFactory\ServerRequest;

use App\Shared\Utils\Strings;
use stdClass;

trait ServerRequestBodyParser
{
    protected static function getBody(): ?stdClass
    {
        if (!isset($_SERVER['CONTENT_TYPE'])) {
            return null;
        }

        $contentType = $_SERVER['CONTENT_TYPE'];

        // form-urlencoded data
        if (Strings::contains($contentType, 'application/x-www-form-urlencoded')) {
            // $input = file_get_contents('php://input', 'r');
            // return (object) parse_url(urldecode($input));
            return (object) $_POST;
        }

        // TODO: Check incoming example request with 'multipart/form-data'
        if (Strings::contains($contentType, 'multipart/form-data')) {
            return null;
        }

        // TODO: Add json_decode flags
        if (Strings::contains($contentType, 'application/json')) {
            $input = file_get_contents('php://input', 'r');
            return json_decode($input);
        }

        return null;
    }
}
