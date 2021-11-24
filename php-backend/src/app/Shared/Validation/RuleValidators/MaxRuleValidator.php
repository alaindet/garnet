<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

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
class MaxRuleValidator extends SingleRuleValidator
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
