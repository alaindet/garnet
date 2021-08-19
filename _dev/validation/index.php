<?php

require __DIR__ . '/vendor/autoload.php';

$input = [
    'name' => 'lorem',
    'foo' => 42,
    // 'bar' => 11,
];

$rules = [
    'name' => [
        'filled' => true,
        'between' => ['a', 'z'],
        // 'in' => ['lorem', 'ipsum', 'dolor', 'sit', 'amet'],
        // 'equals' => 'lorem',
        'is' => 'alphanumeric',
        // 'regex' => '^[^l][orem]{2,}$'
    ],
    'foo' => [
        'equals' => 42,
        'except' => 69,
        'exceptIn' => [13, 43],
        'is' => ['string', 'integer'],
    ],
    'bar' => [
        'required' => true,
        'between' => [0, 10],
    ],
];

$validator = new \App\Validator($input, $rules);

$valid = $validator->validate();

$errors = $validator->errors->getAll();

var_dump([
    'valid' => $valid,
    'errors' => $errors,
]);
