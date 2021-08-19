<?php

namespace App;

use App\RuleValidators\BetweenRuleValidator;
use App\RuleValidators\FilledRuleValidator;
use App\RuleValidators\InRuleValidator;
// ...

/**
 * Validates an associative array
 */
class Validator
{
    public ValidationErrors $errors;

    private array $input = [];
    private array $rules;
    private array $ruleValidators = [
        'between' => BetweenRuleValidator::class,
        'filled' => FilledRuleValidator::class,
        'in' => InRuleValidator::class,
        // ...
    ];

    public function __construct(array $input, ?array $rules = null)
    {
        $this->input = $input;
        $this->rules = $rules;
        $this->errors = new ValidationErrors();
    }

    public function validate(): bool
    {
        foreach ($this->rules as $inputKey => $ruleValidators) {
            foreach ($ruleValidators as $ruleName => $ruleParams) {

                $ruleValidatorClass = $this->ruleValidators[$ruleName];
                $errorBehavior = constant("{$ruleValidatorClass}::ERROR_BEHAVIOR");
                $ruleValidator = new $ruleValidatorClass($this->errors);

                if (!\is_array($ruleParams)) {
                    $ruleParams = [$ruleParams];
                }

                $ruleErrors = $ruleValidator->validate(
                    $this->input,
                    $inputKey,
                    ...$ruleParams
                );

                if ($ruleErrors !== null) {
                    foreach ($ruleErrors as $name => $message) {
                        $this->errors->add($name, $message);
                    }
                }

                // Stop validation?
                $stopsOnError = AbstractRuleValidator::ERROR_BEHAVIOR_STOP;
                if ($errorBehavior === $stopsOnError && $ruleErrors !== null) {
                    return false;
                }
            }
        }

        return $this->errors->isEmpty();
    }
}
