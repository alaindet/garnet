<?php

namespace App\Core\Services\Filesystem;

trait WithFileMethods
{
    static public function getFilename(string $absolutePath): string
    {
        $lastSlash = strrpos($absolutePath, '/');
        $temp = substr($absolutePath, $lastSlash + 1);
        $lastDot = strrpos($temp, '.');
        $extLen = strlen($temp) - strlen(substr($temp, $lastDot));
        $filename = substr($temp, 0, $extLen);

        return $filename;
    }
}