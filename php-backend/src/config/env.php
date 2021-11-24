<?php

return [
    'development' => (
        isset($_ENV['GARNET_APP_ENV']) &&
        $_ENV['GARNET_APP_ENV'] === 'development'
    ),
    'production' => (
        isset($_ENV['GARNET_APP_ENV']) &&
        $_ENV['GARNET_APP_ENV'] === 'production'
    ),
    'debug' => (
        isset($_ENV['GARNET_APP_DEBUG']) &&
        $_ENV['GARNET_APP_DEBUG'] === 'true'
    )
];
