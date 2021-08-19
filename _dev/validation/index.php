<?php

require __DIR__ . '/vendor/autoload.php';

$input = [
    'name' => 'lorem',
    'foo' => 42,
];

$rules = [
    'name' => [
        'filled' => true,
        'between' => ['a', 'z'],
        'in' => ['lorem', 'ipsum', 'dolor', 'sit', 'amet'],
        'equals' => 'lorem',
        'is' => 'alphanumeric',
    ],
    'foo' => [
        'equals' => 42,
        'except' => 69,
        'exceptIn' => [13, 43],
        'is' => ['string', 'integer'],
    ],
];

$validator = new \App\Validator($input, $rules);

$valid = $validator->validate();

$errors = $validator->errors->getAll();

var_dump([
    'valid' => $valid,
    'errors' => $errors,
]);
