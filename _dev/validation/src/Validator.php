<?php

namespace App;

/**
 * Validates an associative array
 */
class Validator
{
    private array $ruleValidators = [
        'between' => BetweenRuleValidator::class,
        // ...
    ];

    private array $input = [];
    private array $rules;

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

                $ruleErrors = $ruleValidator->validate(
                    $this->errors,
                    $this->input,
                    $inputKey,
                    ...$ruleParams
                );

                // Stop validation
                if (
                    $errorBehavior === AbstractRuleValidator::ERROR_BEHAVIOR_STOP &&
                    $ruleErrors !== null
                ) {
                    // TODO: ...
                }

                foreach ($ruleErrors as $name => $message) {
                    $this->errors->add($name, $message);
                }
            }
        }

        return $this->errors->isEmpty();
    }
}

/*

$validator = (
    [
        'foo' => 42,
    ],
    [
        'foo' => [
            'between' => [1, 40],
        ]
    ]
);

*/
