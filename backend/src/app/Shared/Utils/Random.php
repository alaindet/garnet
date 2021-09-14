<?php

namespace App\Shared\Utils;

abstract class Random
{
    static public array $randomPools = [
        RandomTextType::AlphaNumeric => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        RandomTextType::Alphabetic => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        RandomTextType::Hexadecimal => '0123456789abcdef',
        RandomTextType::Numeric => '0123456789',
        RandomTextType::NonZeroNumeric => '123456789',
        RandomTextType::Distinct => '2345679ACDEFHJKLMNPRSTUVWXYZ',
    ];

    /**
     * Thanks to
     * https://gist.github.com/raveren/5555297
     *
     * @param string $type
     * @param integer $length
     * @return void
     */
    static public function getRandomText(
        string|int $type = RandomTextType::AlphaNumeric,
        $length = 8
    ): string
    {
        $pool = self::$randomPools[$type];

        if (!isset($pool)) {
            $pool = (string) $type;
        }

        $token = '';
        $max   = strlen($pool);

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = self::getCryptoSecureRandomNumber(0, $max);
            $token .= $pool[$randomIndex];
        }

        return $token;
    }

    static private function getCryptoSecureRandomNumber(int $min, int $max): int
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min;
        }

        $log = log($range, 2);
        $bytes  = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;

        do {
            $random = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $random = $random & $filter;
        } while ($random >= $range);

        return $min + $random;
    }
}
