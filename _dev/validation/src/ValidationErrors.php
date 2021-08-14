<?php

namespace App;

class ValidationErrors
{
    private $errors = [];

    public function getAll(): array
    {
        return $this->errors;
    }

    public function isEmpty(): bool
    {
        return $this->errors === [];
    }

    public function has(string $name): bool
    {
        return isset($this->errors[$name]);
    }

    public function add(string $name, string $message): void
    {
        $this->errors[$name] = $message;
    }

    public function remove(string $name): void
    {
        $result = [];

        foreach ($this->errors as $key => $value) {
            if ($key !== $name) {
                $result[$key] = $value;
            }
        }

        $this->errors = $result;
    }

    public function clear(): void
    {
        $this->errors = [];
    }
}