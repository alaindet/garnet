<?php

namespace App\Features\Board\Enums;

class TaskState
{
    const ToDo = 1;
    const InProgress = 2;
    const Done = 3;

    static public function getValues(): array
    {
        return array_values(self::getConstants());
    }

    static public function getKeys(): array
    {
        return array_keys(self::getConstants());
    }

    static public function getConstants(): array
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }
}
