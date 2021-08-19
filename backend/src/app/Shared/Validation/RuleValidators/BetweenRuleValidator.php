<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Can validate integer, decimals and strings
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'between' => [0, 10]
 *     ]
 * ])
 */
class BetweenRuleValidator extends SingleRuleValidator
{
    const NAME = 'between';

    protected array $errorTemplates = [
        'between' => 'Value :value must be between :from and :to',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $from = $params[0];
        $to = $params[1];

        if ($value < $from || $value > $to) {
            return [
                'between' => $this->getErrorMessage('between', [
                    ':value' => $value,
                    ':from' => $from,
                    ':to' => $to,
                ]),
            ];
        }

        return null;
    }
}
