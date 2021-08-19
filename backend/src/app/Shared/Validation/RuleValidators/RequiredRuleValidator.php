<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\GroupRuleValidator;
/**
 * Returns error if value is not present but it should be
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'required' => true,
 *     ],
 *     'bar' => [
 *         'required' => false,
 *     ]
 * ])
 */
class RequiredRuleValidator extends GroupRuleValidator
{
    const NAME = 'required';

    // Stop every further validation if a required value is missing!
    const ERROR_BEHAVIOR = self::ERROR_BEHAVIOR_STOP;

    protected array $errorTemplates = [
        'required' => 'Key :key is required',
    ];

    public function validateGroup(array $group, string $key, ...$params): ?array
    {
        $required = $params[0];

        if (!$required) {
            return null;
        }

        if (
            !isset($group[$key]) ||
            (
                isset($group[$key]['error']) &&
                $group[$key]['error'] !== UPLOAD_ERR_OK
            )
        ) {
            return [
                'required' => $this->getErrorMessage('required', [
                    ':key' => $key,
                ]),
            ];
        }

        return null;
    }
}
