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

    protected array $errorTemplates = [
        'required' => 'Key :key is required',
    ];

    public function validateGroup(array $group, string $key, ...$params): ?array
    {
        $required = $params[0];

        $valueExists = (
            isset($group[$key]) ||
            (
                isset($group[$key]['error']) &&
                $group[$key]['error'] === UPLOAD_ERR_OK
            )
        );

        if ($valueExists) {
            return null;
        }

        // Value is missing, stop validation anyway!
        $this->shouldStopValidation(true);

        // Optional, so no error
        if (!$required) {
            return null;
        }

        return [
            'required' => $this->getErrorMessage('required', [
                ':key' => $key,
            ]),
        ];
    }
}
