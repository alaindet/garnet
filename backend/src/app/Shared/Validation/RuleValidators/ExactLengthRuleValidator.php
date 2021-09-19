<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value has length less than or equal to given param
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'exactLength' => 16,
 *     ],
 * ])
 */
class ExactLengthRuleValidator extends SingleRuleValidator
{
    const NAME = 'exactLength';

    protected array $errorTemplates = [
        'exactLength' => 'Length of :value must be equal to :length',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $exactLength = $params[0];
        $valueLength = $this->getValueLength($value);

        if ($valueLength !== $exactLength) {
            return [
                'exactLength' => $this->getErrorMessage('exactLength', [
                    ':value' => $value,
                    ':length' => $exactLength,
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
