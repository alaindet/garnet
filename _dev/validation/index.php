<?php

require __DIR__ . '/vendor/autoload.php';

$input = [
    'name' => 'Lorem',
];

$rules = [
    'name' => [
        'between' => ['aaron', 'zachary'],
    ],
];

$validator = new \App\Validator($input, $rules);

$validator->validate();

// $validator = new GroupValidator([
//     'name' => '',
// ]);