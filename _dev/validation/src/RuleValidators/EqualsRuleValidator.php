<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

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
class EqualsRuleValidator extends AbstractSingleRuleValidator
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
