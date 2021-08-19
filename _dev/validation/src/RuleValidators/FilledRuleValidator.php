<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

/**
 * Checks if single value is empty or not
 * If param is "true", value must be filled
 * If param is "false", value must NOT be filled (null, empty string, empty
 * array)
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'filled' => true,
 *     ],
 *     'bar' => [
 *         'filled' => false,
 *     ],
 * ])
 */
class FilledRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'filled';

    protected array $errorTemplates = [
        'filledTrue' => 'Value :value must be filled',
        'filledFalse' => 'Value :value must not be filled',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $shouldBeFilled = $params[0];

        $isFilled = (
            $value !== null &&
            $value !== [] &&
            $value !== ''
        );

        if ($shouldBeFilled && !$isFilled) {
            return [
                'filled' => $this->getErrorMessage('filledTrue', [
                    ':value' => $value,
                ])
            ];
        }

        if (!$shouldBeFilled && $isFilled) {
            return [
                'filled' => $this->getErrorMessage('filledFalse', [
                    ':value' => $value,
                ])
            ];
        }

        return null;
    }
}
