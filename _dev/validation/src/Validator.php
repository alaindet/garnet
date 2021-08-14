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
    /**
     * validate
     *
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules as $inputKey => $ruleValidators) {
            foreach ($ruleValidators as $ruleName => $ruleParams) {
                // ...


                // $bits = explode(':', $rule, 2);
                // $ruleName = $bits[0];
                // $ruleValue = $bits[1] ?? null;
                // $validator = $this->validators[$ruleName];
                // $this->$validator($inputName, $ruleValue);

                // // $skip === true Skips remaining rules, doesn't add errors
                // if ($this->skip) break;
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