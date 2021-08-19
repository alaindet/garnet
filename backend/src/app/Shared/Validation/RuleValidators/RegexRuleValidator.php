<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;

/**
 * Checks if single value is not equal to some value
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'regex' => '^[0-9]{2,}$',
 *     ],
 * ])
 */
class RegexRuleValidator extends SingleRuleValidator
{
    const NAME = 'regex';

    protected array $errorTemplates = [
        'regex' => 'Value :value must match pattern :pattern',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $pattern = "~{$params[0]}~";

        if (!preg_match($pattern, $value)) {
            return [
                'regex' => $this->getErrorMessage('regex', [
                    ':value' => $value,
                    ':pattern' => $pattern,
                ]),
            ];
        }

        return null;
    }
}
