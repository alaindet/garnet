<?php

namespace App;

trait AbstractRuleValidatorErrorMessages
{
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
            $withThis[] = $this->getValueStringRepresentation($value);
        }

        return str_replace($replaceThis, $withThis, $template);
    }

    private function getValueStringRepresentation($value): string
    {
        switch (gettype($value)) {
            case 'string':
                return "\"{$value}\"";
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'array':
                if (!isAssoc($value)) {
                    return '[' . implode(', ', $value) . ']';
                }

                $lines = [];
                foreach ($value as $key => $val) {
                    $key = \is_int($key) ? $key : "'{$key}'";
                    $lines[] = "{$key} => {$val}";
                }
                return '[' . implode(', ', $lines) . ']';

            case 'NULL':
                return 'null';
            default:
                return $value;
        }
    }
}
