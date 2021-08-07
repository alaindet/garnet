<?php

return [
    'host' => 'mariadb',
    'database' => 'garnet',
    'user' => 'garnet',
    'password' => 'garnet',
    'port' => 3306,
    'charset' => 'utf8',
    'options' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ],
];