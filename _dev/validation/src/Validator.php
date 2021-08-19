<?php

namespace App;

use App\RuleValidators\BetweenRuleValidator;
use App\RuleValidators\EqualsRuleValidator;
use App\RuleValidators\ExceptInRuleValidator;
use App\RuleValidators\ExceptRuleValidator;
use App\RuleValidators\FilledRuleValidator;
use App\RuleValidators\InRuleValidator;
use App\RuleValidators\IsRuleValidator;
use App\RuleValidators\MaxLengthRuleValidator;
use App\RuleValidators\MaxRuleValidator;
use App\RuleValidators\MinLengthRuleValidator;
use App\RuleValidators\MinRuleValidator;
use App\RuleValidators\RegexRuleValidator;
use App\RuleValidators\RequiredRuleValidator;
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
        'equals' => EqualsRuleValidator::class,
        'except' => ExceptRuleValidator::class,
        'exceptIn' => ExceptInRuleValidator::class,
        'filled' => FilledRuleValidator::class,
        'in' => InRuleValidator::class,
        'is' => IsRuleValidator::class,
        'maxLength' => MaxLengthRuleValidator::class,
        'max' => MaxRuleValidator::class,
        'minLength' => MinLengthRuleValidator::class,
        'min' => MinRuleValidator::class,
        'regex' => RegexRuleValidator::class,
        'required' => RequiredRuleValidator::class,
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
                    foreach ($ruleErrors as $ruleErrorKey => $ruleErrorMessage) {
                        $key = "{$inputKey}.{$ruleErrorKey}";
                        $this->errors->add($key, $ruleErrorMessage);
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
