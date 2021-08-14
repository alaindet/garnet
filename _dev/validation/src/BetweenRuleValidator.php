<?php

namespace App;

/**
 * Can validate integer, decimals and strings
 * 
 * Ex.:
 * validate([
 *     'foo' => [
 *         'between' => [0, 10]
 *     ]
 * ])
 */
class BetweenRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'between';

    public function validateSingle($value, array ...$params): ?array
    {
        $from = $params['from'];
        $to = $params['to'];

        if ($value < $from || $value > $to) {
            $errors = [];
            $message = "Input {$value} must be between {$from} and {$to}";
            $errors[self::NAME] = $message;
            return $errors;
        }

        return null;
    }
}