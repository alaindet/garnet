<?php

namespace App\Shared\Validation;

use App\Core\Exceptions\Validation\ValidationException;
use App\Shared\Validation\RuleValidators\BetweenRuleValidator;
use App\Shared\Validation\RuleValidators\EmailRuleValidator;
use App\Shared\Validation\RuleValidators\EqualsRuleValidator;
use App\Shared\Validation\RuleValidators\ExactLengthRuleValidator;
use App\Shared\Validation\RuleValidators\ExceptInRuleValidator;
use App\Shared\Validation\RuleValidators\ExceptRuleValidator;
use App\Shared\Validation\RuleValidators\ExistsOnDatabaseRuleValidator;
use App\Shared\Validation\RuleValidators\FilledRuleValidator;
use App\Shared\Validation\RuleValidators\InRuleValidator;
use App\Shared\Validation\RuleValidators\IsRuleValidator;
use App\Shared\Validation\RuleValidators\MaxLengthRuleValidator;
use App\Shared\Validation\RuleValidators\MaxRuleValidator;
use App\Shared\Validation\RuleValidators\MinLengthRuleValidator;
use App\Shared\Validation\RuleValidators\MinRuleValidator;
use App\Shared\Validation\RuleValidators\MissingOnDatabaseRuleValidator;
use App\Shared\Validation\RuleValidators\RegexRuleValidator;
use App\Shared\Validation\RuleValidators\RequiredRuleValidator;

// ...

/**
 * Validates an associative array
 */
class Validator
{
    private array | null $input = [];
    private array $errors = [];
    private array $rules;
    private array $ruleValidators = [
        'between' => BetweenRuleValidator::class,
        'email' => EmailRuleValidator::class,
        'equals' => EqualsRuleValidator::class,
        'exactLength' => ExactLengthRuleValidator::class,
        'except' => ExceptRuleValidator::class,
        'exceptIn' => ExceptInRuleValidator::class,
        'existsOnDatabase' => ExistsOnDatabaseRuleValidator::class,
        'filled' => FilledRuleValidator::class,
        'in' => InRuleValidator::class,
        'is' => IsRuleValidator::class,
        'max' => MaxRuleValidator::class,
        'maxLength' => MaxLengthRuleValidator::class,
        'min' => MinRuleValidator::class,
        'minLength' => MinLengthRuleValidator::class,
        'missingOnDatabase' => MissingOnDatabaseRuleValidator::class,
        'regex' => RegexRuleValidator::class,
        'required' => RequiredRuleValidator::class,
        // ...
    ];

    public function __construct(array | null $input = null, ?array $rules = null)
    {
        $this->input = $input;
        $this->rules = $rules;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->input)) {
            $this->errors['validation'] = 'No input provided';
            return false;
        }

        foreach ($this->rules as $inputKey => $ruleValidators) {
            foreach ($ruleValidators as $ruleName => $ruleParams) {

                $ruleValidatorClass = $this->ruleValidators[$ruleName];
                $ruleValidator = new $ruleValidatorClass($this->errors);

                if (!\is_array($ruleParams)) {
                    $ruleParams = [$ruleParams];
                }

                // Evaluate rule validator
                $ruleErrors = $ruleValidator->validate(
                    $this->input,
                    $inputKey,
                    ...$ruleParams
                );

                // Add errors
                if ($ruleErrors !== null) {

                    foreach ($ruleErrors as $ruleErrorKey => $ruleErrorMessage) {

                        if (!isset($this->errors[$inputKey])) {
                            $this->errors[$inputKey] = [];
                        }

                        $this->errors[$inputKey][$ruleErrorKey] = $ruleErrorMessage;
                    }
                }

                // Stop validation?
                if ($ruleValidator->shouldStopValidation()) {
                    return $this->errors === [];
                }
            }
        }

        return $this->errors === [];
    }
}
