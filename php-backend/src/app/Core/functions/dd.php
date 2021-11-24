<?php

/**
 * This is the only function without the "app" prefix as it is only used in
 * development and should not be part of the final code
 *
 * @param mixed $value
 * @return void
 */
function dd($value)
{
    echo '<pre>' . print_r($value, true) . '</pre>';
    die();

    // var_dump($value);
    // die();
}
