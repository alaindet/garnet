<?php

namespace App\Shared\Utils;

abstract class Strings
{
    static public function startsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    static public function contains(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }
}
