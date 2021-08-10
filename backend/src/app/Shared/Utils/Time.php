<?php

namespace App\Shared\Utils;

abstract class Time
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    static public function getTimestamp(?string $date = null): int
    {
        return ($date !== null)
            ? strtotime($date) * 1000
            : microtime(true) * 1000;
    }
    
    static public function getDate(?int $timestamp = null): string
    {
        $dateFormat = 'Y-m-d H:i:s.v';
    
        return ($timestamp !== null)
            ? date(self::DATE_FORMAT, $timestamp / 1000)
            : date(self::DATE_FORMAT);
    }
}
