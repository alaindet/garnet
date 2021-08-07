<?php

return [
    'cors.origin' => $_ENV['GARNET_SECURITY_CORS_ORIGIN'],
    'jwt.secret' => $_ENV['GARNET_SECURITY_JWT_SECRET'],
    'jwt.issuer' => $_ENV['GARNET_SECURITY_JWT_ISSUER'],
    'jwt.expires' => $_ENV['GARNET_SECURITY_JWT_EXPIRES_IN'],
];