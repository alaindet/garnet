<?php

namespace App;

abstract class AbstractRuleValidator
{
    const ERROR_BEHAVIOR_CONTINUE = 1; // Continues validation pipeline on error
    const ERROR_BEHAVIOR_STOP = 2; // Stops validation pipeline on error
    const CONTEXT_SINGLE = 3; // Validates only a value of the group
    const CONTEXT_GROUP = 4; // Validates 2+ values of the group

    // Overwrite these in child classes
    const NAME = 'overwrite-this';
    const ERROR_BEHAVIOR = self::ERROR_BEHAVIOR_CONTINUE;

    /**
     * Contains the strings to use as templates on error
     * Template variables are prefixed with :, ex.: :value
     * The key is the error name, the value is the template
     *
     * This is overridden by child classes and further overridden by user
     * if needed, for example for internationalization
     *
     * Ex.:
     * ['between' => 'Value :value is not between :from and :to']
     *
     * @var array
     */
    protected array $errorTemplates = [];

    protected function setErrorTemplate(string $name, string $template): void
    {
        $this->errorTemplates[$name] = $template;
    }

    protected function getErrorMessage(
        string $templateName,
        array $params
    ): string
    {
        $template = $this->errorTemplates[$templateName];

        $replaceThis = [];
        $withThis = [];

        foreach ($params as $placeholder => $value) {
            $replaceThis[] = $placeholder;
            $withThis[] = $value;
        }

        return str_replace($replaceThis, $withThis, $template);
    }

    /**
     * Executes a sigle context or group context rule validator based on the
     * configuration of the rule validator instance extending this class
     *
     * @param array $group Group to validate
     * @param string $key Key of the value to validate
     * @param array ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    public function validate(
        array $group,
        string $key,
        array ...$params
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
     * @param array ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    protected function validateSingle(
        $value,
        array ...$params
    ): ?array
    {
        // ...

        return  null;
    }

    /**
     * Overwrite this in child class if self::context is group
     *
     * @param array $group Group to validate
     * @param string $key Key of the value to validate
     * @param array ...$params Validator parameters
     * @return array|null NULL means ok (no errors), otherwise return assoc array
     */
    protected function validateGroup(
        array $group,
        string $key,
        array ...$params
    ): ?array
    {
        // ...

        return null;
    }
}
