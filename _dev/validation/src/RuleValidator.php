<?php

namespace App;

abstract class RuleValidator
{
    const ERROR_BEHAVIOR_CONTINUE = 1; // Continues validation pipeline on error
    const ERROR_BEHAVIOR_STOP = 2; // Stops validation pipeline on error
    const CONTEXT_SINGLE = 3; // Validates only a value of the group
    const CONTEXT_GROUP = 4; // Validates 2+ values of the group

    // Overwrite these in child class
    public $name = 'rule-validator';
    public $errorBehavior = self::ERROR_BEHAVIOR_CONTINUE;
    public $context = self::CONTEXT_SINGLE;

    protected ValidationErrors $errors;

    public function __construct(ValidationErrors $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Overwrite this in child class if self::context is 'single'
     *
     * @param ValidationErrors $errors
     * @param mixed $value Single value to validate
     * @param array ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    public function validateSingle(
        ValidationErrors $errors,
        $value,
        array ...$params
    ): ValidationErrors
    {
        // ...

        return $errors;
    }

    /**
     * Overwrite this in child class if self::context is 'group'
     *
     * @param ValidationErrors $errors
     * @param array $group Group to validate
     * @param string $key Key of the value to validate
     * @param array ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    public function validateGroup(
        ValidationErrors $errors,
        array $group,
        string $key,
        array ...$params
    ): ValidationErrors
    {
        // ...

        return $errors;
    }
}