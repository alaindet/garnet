<?php

require __DIR__ . '/vendor/autoload.php';

$input = [
    'name' => 'lorem',
];

$rules = [
    'name' => [
        'between' => ['aaron', 'zachary'],
    ],
];

$validator = new \App\Validator($input, $rules);

$valid = $validator->validate();

var_dump($valid);

// $validator = new GroupValidator([
//     'name' => '',
// ]);
