<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value is not equal to some value
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'except' => 42,
 *     ],
 * ])
 */
class ExceptRuleValidator extends SingleRuleValidator
{
    const NAME = 'except';

    protected array $errorTemplates = [
        'except' => 'Value :value must not be equal to :except',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $except = $params[0];

        if ($value === $except) {
            return [
                'except' => $this->getErrorMessage('except', [
                    ':value' => $value,
                    ':except' => $except,
                ]),
            ];
        }

        return null;
    }
}
