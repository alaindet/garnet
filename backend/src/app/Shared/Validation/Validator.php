<?php

namespace App\Shared\Validation;

use App\Shared\Validation\RuleValidator\RuleValidator;
use App\Shared\Validation\RuleValidators\BetweenRuleValidator;
use App\Shared\Validation\RuleValidators\EqualsRuleValidator;
use App\Shared\Validation\RuleValidators\ExceptInRuleValidator;
use App\Shared\Validation\RuleValidators\ExceptRuleValidator;
use App\Shared\Validation\RuleValidators\FilledRuleValidator;
use App\Shared\Validation\RuleValidators\InRuleValidator;
use App\Shared\Validation\RuleValidators\IsRuleValidator;
use App\Shared\Validation\RuleValidators\MaxLengthRuleValidator;
use App\Shared\Validation\RuleValidators\MaxRuleValidator;
use App\Shared\Validation\RuleValidators\MinLengthRuleValidator;
use App\Shared\Validation\RuleValidators\MinRuleValidator;
use App\Shared\Validation\RuleValidators\RegexRuleValidator;
use App\Shared\Validation\RuleValidators\RequiredRuleValidator;
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
                $stopsOnError = RuleValidator::ERROR_BEHAVIOR_STOP;
                if ($errorBehavior === $stopsOnError && $ruleErrors !== null) {
                    return false;
                }
            }
        }

        return $this->errors->isEmpty();
    }
}
