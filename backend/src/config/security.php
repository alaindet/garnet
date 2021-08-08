<?php

return [

    'cors.origin' => $_ENV['GARNET_SECURITY_CORS_ORIGIN'],
    'cors.methods' => $_ENV['GARNET_SECURITY_CORS_METHODS'],
    'cors.maxage' => $_ENV['GARNET_SECURITY_CORS_MAX_AGE'],
    'cors.headers' => $_ENV['GARNET_SECURITY_CORS_HEADERS'],

    'jwt.secret' => $_ENV['GARNET_SECURITY_JWT_SECRET'],
    'jwt.issuer' => $_ENV['GARNET_SECURITY_JWT_ISSUER'],
    'jwt.expires' => $_ENV['GARNET_SECURITY_JWT_EXPIRES_IN'],

];