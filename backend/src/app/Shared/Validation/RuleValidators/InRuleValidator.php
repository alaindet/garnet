<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if value is contained in a whitelist
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'in' => ['lorem', 'ipsum', 'dolor', 'sit', 'amet'],
 *     ]
 * ])
 */
class InRuleValidator extends SingleRuleValidator
{
    const NAME = 'in';

    protected array $errorTemplates = [
        'in' => 'Value :value must be in :list',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $list = $params;

        if (!in_array($value, $list, $strict = true)) {
            return [
                'in' => $this->getErrorMessage('in', [
                    ':value' => $value,
                    ':list' => $list,
                ]),
            ];
        }
        return null;
    }
}
