<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value is a valid email
 * 
 * Ex.:
 * validate([
 *     'foo' => [
 *         'email' => true,
 *     ],
 * ])
 */
class EmailRuleValidator extends SingleRuleValidator
{
    const NAME = 'email';

    protected array $errorTemplates = [
        'email' => 'Value :value must be a valid email address',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $this->getErrorMessage('email', [
                    ':value' => $value,
                ])
            ];
        }

        return null;
    }
}
