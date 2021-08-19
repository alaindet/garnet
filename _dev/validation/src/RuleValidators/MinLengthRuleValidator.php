<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

/**
 * Checks if single value has length greater than or equal to given param
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'minLength' => 3,
 *     ],
 * ])
 */
class MaxLengthRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'minLength';

    protected array $errorTemplates = [
        'minLength' => 'Length of :value must be greater than or equal to :min',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $minLength = $params[0];
        $valueLength = $this->getValueLength($value);

        if ($valueLength < $minLength) {
            return [
                'minLength' => $this->getErrorMessage('minLength', [
                    ':value' => $value,
                    ':min' => $minLength,
                ]),
            ];
        }

        return null;
    }

    private function getValueLength($value): int
    {
        if (\is_array($value)) {
            return count($value);
        }

        if (\is_string($value)) {
            return strlen($value);
        }

        return 0;
    }
}
