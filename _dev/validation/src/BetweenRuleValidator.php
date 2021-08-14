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
class BetweenRuleValidator extends RuleValidator
{
    public $name = 'between';
    public $errorBehavior = RuleValidator::ERROR_BEHAVIOR_CONTINUE;
    public $context = RuleValidator::CONTEXT_SINGLE;

    public function validateSingle(
        ValidationErrors $errors,
        $value,
        array ...$params
    ): ValidationErrors
    {
        $from = $params['from'];
        $to = $params['to'];

        if ($value < $from || $value > $to) {
            $message = "Input {$value} must be between {$from} and {$to}";
            $this->errors->add($this->name, $message);
        }

        return $errors;
    }
}