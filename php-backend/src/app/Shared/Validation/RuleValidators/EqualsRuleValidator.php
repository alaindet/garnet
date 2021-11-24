<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value is equal to some value
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'equals' => 42,
 *     ],
 * ])
 */
class EqualsRuleValidator extends SingleRuleValidator
{
    const NAME = 'equals';

    protected array $errorTemplates = [
        'equals' => 'Value :value must be equal to :equals',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $equals = $params[0];

        if ($value !== $equals) {
            return [
                'equals' => $this->getErrorMessage('equals', [
                    ':value' => $value,
                    ':equals' => $equals,
                ]),
            ];
        }

        return null;
    }
}
