<?php

namespace App\Core\Http\RequestFactory\ServerRequest;

use App\Core\Http\Request\Request;

trait WithServerRequest
{
    use ServerRequestBodyParser;
    use ServerRequestPathParser;
    use ServerRequestHeadersParser;

    static public function createsServerRequestFromGlobals(): Request
    {
        $req = new Request();

        $req->setMethod($_SERVER['REQUEST_METHOD']);
        $req->setPath(self::getPath());

        $req->setHeaders(self::getHeaders());
        $req->setBody(self::getBody());
        if (!empty($_SERVER['QUERY_STRING'])) {
            $req->setQuery($_SERVER['QUERY_STRING']);
        }

        return $req;
    }
}
