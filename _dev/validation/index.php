<?php

require __DIR__ . '/vendor/autoload.php';

$input = [
    'name' => 'lorem',
];

$rules = [
    'name' => [
        'filled' => true,
        'between' => ['a', 'z'],
        'in' => ['lorem', 'ipsum', 'dolor', 'sit', 'amet'],
    ],
];

$validator = new \App\Validator($input, $rules);

$valid = $validator->validate();

$errors = $validator->errors->getAll();

var_dump([
    'valid' => $valid,
    'errors' => $errors,
]);
