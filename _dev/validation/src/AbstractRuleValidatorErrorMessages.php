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
            $withThis[] = $this->getRepresentation($value);
        }

        return str_replace($replaceThis, $withThis, $template);
    }

    private function getRepresentation($value): string
    {
        $type = gettype($value);

        if ($type !== 'array') {
            return $this->getPrimitiveRepresentation($value, $type);
        }

        if (!isAssoc($value)) {
            $lines = array_map(
                fn($item) => $this->getRepresentation($item),
                $value
            );
            return '[' . implode(', ', $lines) . ']';
        }

        $lines = [];

        foreach ($value as $_key => $_val) {
            $key = \is_int($_key) ? $_key : "'{$_key}'";
            $val = $this->getPrimitiveRepresentation($_val);
            $lines[] = "{$key} => {$val}";
        }

        return '[' . implode(', ', $lines) . ']';
    }

    private function getPrimitiveRepresentation($value, ?string $type = null): string
    {
        $type = $type ?? gettype($value);

        switch ($type) {
            case 'string':
                return "\"{$value}\"";
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'NULL':
                return 'null';
            default:
                return $value;
        }
    }
}
