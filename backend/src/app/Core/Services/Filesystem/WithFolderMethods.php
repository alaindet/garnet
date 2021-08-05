<?php

namespace App\Core\Services\Filesystem;

trait WithFolderMethods
{
    static public function scan(string $dir): array
    {
        $files = [];

        foreach (scandir($dir) as $file) {
            if ($file !== '.' && $file !== '..') {
                $files[] = $dir . '/' . $file;
            }
        }

        return $files;
    }
}