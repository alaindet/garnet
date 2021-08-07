<?php

namespace App;

class Configuration
{
    private $data = [];

    public function __construct()
    {
        echo 'Configuration::__construct';
        $this->build();
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    private function build(): void
    {
        $this->data = array_merge(
            [],
            $this->buildDatabase(),
            // ...
        );
    }

    private function buildDatabase(): array
    {
        $result = [];

        $database = require_once dirname(__DIR__) . '/database.php';

        foreach ($database as $key => $value) {
            $compositeKey = "database.{$key}";
            $result[$compositeKey] = $value;
        }

        return $result;
    }
}