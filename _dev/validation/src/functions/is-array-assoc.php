<?php

/**
 * Reference
 * https://stackoverflow.com/a/173479
 *
 * @param array $arr
 * @return boolean
 */
function isAssoc(array $arr)
{
    if ($arr === []) {
        return false;
    }

    return array_keys($arr) !== range(0, count($arr) - 1);
}
