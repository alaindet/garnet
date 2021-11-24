<?php

namespace App\Core\Common;

trait GetterSetter
{
    protected function getOrSet(string $key, $val)
    {
        if (!isset($val)) {
            return $this->$key;
        }

        $this->$key = $val;
        return $this;
    }
}
