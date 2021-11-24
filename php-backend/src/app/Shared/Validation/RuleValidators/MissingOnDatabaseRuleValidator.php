<?php

namespace App\Shared\Validation\RuleValidators;

use App\Shared\Validation\RuleValidator\SingleRuleValidator;
use App\Core\Services\Database\Database;

/**
 * Checks if single value is a valid email
 * 
 * Ex.:
 * validate([
 *     'foo' => [
 *         'missingOnDatabase' => ['my_table', 'my_field'],
 *     ],
 * ])
 */
class MissingOnDatabaseRuleValidator extends SingleRuleValidator
{
    const NAME = 'missingOnDatabase';

    protected array $errorTemplates = [
        'missingOnDatabase' => 'Value :value does already exist on field :field of table :table',
    ];

    public function validateSingle($value, ...$params): ?array
    {
        $table = $params[0];
        $field = $params[1];

        $db = appServiceProvider(Database::class);
        $sql = "SELECT COUNT({$field}) AS cnt FROM {$table} WHERE {$field} = :val";
        $params = [':val' => $value];
        $result = $db->selectFirst($sql, $params);

        if (isset($result) && $result['cnt'] > 0) {
            return [
                'missingOnDatabase' => $this->getErrorMessage('missingOnDatabase', [
                    ':value' => $value,
                    ':field' => $field,
                    ':table' => $table,
                ])
            ];
        }

        return null;
    }
}
