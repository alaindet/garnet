<?php

namespace App\Shared\Utils;

abstract class Arrays
{
    static public function filter(array $arr, $callback): array
    {
        $result = [];

        for ($i = 0, $len = count($arr); $i < $len; $i++) {
            if ($callback($arr[$i], $i,)) {
                $result[] = $arr[$i];
            }
        }

        return $result;
    }

    static public function filterAssoc(array $arr, $callback): array
    {
        $result = [];
        $i = 0;


        foreach ($arr as $key => $value) {
            if ($callback($value, $key, $i)) {
                $result[$key] = $value;
            }
            $i++;
        }

        return $result;
    }

    static public function map(array $arr, $callback): array
    {
        $result = [];

        for ($i = 0, $len = count($arr); $i < $len; $i++) {
            $result[] = $callback($arr[$i], $i, $arr);
        }

        return $result;
    }

    static public function mapAssoc(array $arr, $callback): array
    {
        $result = [];
        $i = 0;

        foreach ($arr as $key => $value) {
            $result[$key] = $callback($value, $key, $i);
            $i++;
        }

        return $result;
    }
}
