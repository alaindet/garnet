<?php

namespace App\Core\Http\RequestFactory\ServerRequest;

use App\Shared\Utils\Strings;

trait ServerRequestHeadersParser
{
    /**
     * Adapted from
     * https://gist.github.com/speccode/1d5633cd3db669a786c0868c8b94f644
     *
     * @return array
     */
    protected static function getHeaders(): array
    {
        if (function_exists('getallheaders')) {
            $rawHeaders = getallheaders();
            if ($rawHeaders === false) {
                return [];
            }
            $headers = [];
            foreach ($rawHeaders as $name => $value) {
                $parsedName = str_replace(' ', '-', ucwords(
                    str_replace('-', ' ', $name)
                ));
                $headers[$parsedName] = $value;
            }
            return $headers;
        }

        if (!is_array($_SERVER)) {
            return [];
        }

        $headers = [];

        foreach ($_SERVER as $name => $value) {
            if ($name === 'CONTENT_TYPE') {
                $headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            } elseif ($name === 'CONTENT_LENGTH') {
                $headers['Content-Length'] = $_SERVER['CONTENT_LENGTH'];
            } elseif (Strings::startsWith($name, 'HTTP_')) {
                $key = str_replace(
                    ' ',
                    '-',
                    ucwords(
                        strtolower(
                            str_replace('_', ' ', substr($name, 5))
                        )
                    )
                );

                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}
