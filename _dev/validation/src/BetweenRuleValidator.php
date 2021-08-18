<?php

namespace App;

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
class BetweenRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'between';

    protected array $errorTemplates = [
        'between' => 'Value :value must be between :from and :to',
    ];

    public function validateSingle($value, array ...$params): ?array
    {
        $from = $params['from'];
        $to = $params['to'];

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
