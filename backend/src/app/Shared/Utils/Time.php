<?php

namespace App\Shared\Utils;

abstract class Time
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    static public function getTimestamp(): int
    {
        return round(microtime(true) * 1000);
    }

    static public function getTimestampFromDatetime(string $date): int
    {
        return strtotime($date) * 1000;
    }

    static public function getDatetimeFromTimestamp(int $unixTimestamp): string
    {
        return date(self::DATE_FORMAT, $unixTimestamp / 1000);
    }

    static public function getCurrentDate(): string
    {
        return date(self::DATE_FORMAT, time());
    }

    static public function getCurrentTimestamp(): int
    {
        return time() * 1000;
    }
}
