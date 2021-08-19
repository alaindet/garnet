<?php

namespace App\RuleValidators;

use App\AbstractSingleRuleValidator;

/**
 * Checks if value is type
 *
 * Ex.:
 * validate([
 *     'foo' => [
 *         'is' => 'integer',
 *     ],
 *     'bar' => [
 *         'is' => ['integer', 'double', 'string'],
 *     ],
 * ])
 */
class IsRuleValidator extends AbstractSingleRuleValidator
{
    const NAME = 'is';

    protected array $errorTemplates = [
        'is' => 'Value :value must be of type :type',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $allowedTypes = $params;

        foreach ($allowedTypes as $allowedType) {
            if ($this->isOfType($value, $allowedType)) {
                return null;
            }
        }

        return [
            'is' => $this->getErrorMessage('is', [
                ':value' => $value,
                ':type' => count($allowedTypes) === 1
                    ? $allowedTypes[0]
                    : $allowedTypes
            ])
        ];
    }

    private function isOfType($value, string $typeConstraint): bool
    {
        switch ($typeConstraint) {
            case 'date':
                return strtotime($value) !== false;
            case 'alphanumeric':
                return preg_match('/^[a-zA-Z0-9]+$/', $value);
            case 'file':
                return $value['error'] !== UPLOAD_ERR_OK;
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
            case 'array':
            case 'object':
            case 'NULL':
                return gettype($value) === $typeConstraint;
        }
    }
}
