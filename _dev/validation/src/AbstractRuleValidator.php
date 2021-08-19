<?php

namespace App;

abstract class AbstractRuleValidator
{
    use AbstractRuleValidatorErrorMessages;

    const ERROR_BEHAVIOR_CONTINUE = 1; // Continues validation pipeline on error
    const ERROR_BEHAVIOR_STOP = 2; // Stops validation pipeline on error
    const CONTEXT_SINGLE = 3; // Validates only a value of the group
    const CONTEXT_GROUP = 4; // Validates 2+ values of the group

    // Overwrite these in child classes
    const NAME = 'name-of-the-rule-validator';
    const ERROR_BEHAVIOR = self::ERROR_BEHAVIOR_CONTINUE;

    /**
     * Executes a sigle context or group context rule validator based on the
     * configuration of the rule validator instance extending this class
     *
     * @param array $group Group to validate
     * @param string $key Key of the value to validate
     * @param mixed ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    public function validate(
        array $group,
        string $key,
        ...$params
    ): ?array
    {
        $className = get_called_class();
        $context = constant("{$className}::CONTEXT");

        if ($context === self::CONTEXT_GROUP) {
            return $this->validateGroup($group, $key, ...$params);
        }

        return $this->validateSingle($group[$key], ...$params);
    }

    /**
     * Overwrite this in child class if self::context is single
     *
     * @param mixed $value Single value to validate
     * @param mixed ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    protected function validateSingle($value, ...$params): ?array
    {
        // ...

        return  null;
    }

    /**
     * Overwrite this in child class if self::context is group
     *
     * @param array $group Group to validate
     * @param string $key Key of the value to validate
     * @param mixed ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    protected function validateGroup(
        array $group,
        string $key,
        ...$params
    ): ?array
    {
        // ...

        return null;
    }
}
