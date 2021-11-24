<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value is not equal to some value
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'exceptIn' => [13, 42, 69],
 *     ],
 * ])
 */
class ExceptInRuleValidator extends SingleRuleValidator
{
    const NAME = 'exceptIn';

    protected array $errorTemplates = [
        'exceptIn' => 'Value :value must not be one of these :except',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $exceptList = $params;

        foreach ($exceptList as $except) {
            if ($value === $except) {
                return [
                    'exceptIn' => $this->getErrorMessage('exceptIn', [
                        ':value' => $value,
                        ':except' => $exceptList,
                    ]),
                ];
            }

        }

        return null;
    }
}
