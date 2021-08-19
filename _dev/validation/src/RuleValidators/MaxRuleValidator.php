<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

/**
 * Checks if single value is less than or equal to given param
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'max' => 100,
 *     ],
 * ])
 */
class MaxRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'max';

    protected array $errorTemplates = [
        'max' => 'Value :value must be less than or equal to :max',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $max = $params[0];

        if ($value > $max) {
            return [
                'max' => $this->getErrorMessage('max', [
                    ':value' => $value,
                    ':max' => $max,
                ]),
            ];
        }

        return null;
    }
}
