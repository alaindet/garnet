<?php

namespace App\Core\Services\Filesystem\Format;

abstract class PhpAssociativeArray
{
    static public function toFileContent(
        array $data,
        bool $pretty = false
    ): string
    {
        $stringifiedArray = self::stringify($data, $pretty);

        return $pretty
            ? "<?php\n\nreturn {$stringifiedArray};"
            : "<?php return {$stringifiedArray};";
    }

    static private function stringify(
        array $data,
        bool $pretty = false,
        int $nesting = 0
    ): string
    {
        $lines = '';
        $tab = \str_repeat(' ', 4);

        $parentNesting = $nesting;
        $parentNestingTabs = \str_repeat($tab, $parentNesting);
        $contentNesting = $parentNesting + 1;
        $contentNestingTabs = $parentNestingTabs . $tab;

        foreach ($data as $key => $value) {

            $parsedKey = \is_int($key)
                ? $key
                : "'{$key}'";

            $parsedValue = \is_array($value)
                ? self::stringify($value, $pretty, $contentNesting)
                : self::parseValue($value);

            $lines .= $pretty
                ? "{$contentNestingTabs}{$parsedKey} => {$parsedValue},\n"
                : "{$parsedKey}=>{$parsedValue},";
        }

        $lines = substr($lines, 0, -1);

        return $pretty
            ? "[\n{$lines}\n{$parentNestingTabs}]"
            : "[{$lines}]";
    }

    static private function parseValue($value): string
    {
        switch (gettype($value)) {
            case 'string':
                return "'{$value}'";
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'integer':
            case 'double':
            case 'float':
                return "{$value}";
        }
    }
}
