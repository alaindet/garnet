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
        'filled-true' => 'Value :value must be filled',
        'filled-false' => 'Value :value must not be filled',
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
                'filled' => $this->getErrorMessage('filled-true', [
                    ':value' => $value,
                ])
            ];
        }

        if (!$shouldBeFilled && $isFilled) {
            return [
                'filled' => $this->getErrorMessage('filled-false', [
                    ':value' => $value,
                ])
            ];
        }

        return null;
    }
}
