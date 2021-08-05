<?php

return [
    'development' => (
        isset($_ENV['APP_ENV']) &&
        $_ENV['APP_ENV'] === 'development'
    ),
    'production' => (
        isset($_ENV['APP_ENV']) &&
        $_ENV['APP_ENV'] === 'production'
    ),
    'debug' => (
        isset($_ENV['APP_DEBUG']) &&
        $_ENV['APP_DEBUG'] === 'true'
    )
];
