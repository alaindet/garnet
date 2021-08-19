<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

/**
 * Checks if single value is greater than or equal to given param
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'min' => 6,
 *     ],
 * ])
 */
class MinRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'min';

    protected array $errorTemplates = [
        'min' => 'Value :value must be greater than or equal to :min',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $min = $params[0];

        if ($value < $min) {
            return [
                'min' => $this->getErrorMessage('min', [
                    ':value' => $value,
                    ':min' => $min,
                ]),
            ];
        }

        return null;
    }
}
