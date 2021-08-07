<?php

namespace App\Core\Http\Message;

use App\Shared\Utils\Arrays;

trait MessageWithHeaders
{
    /**
     * Ex.:
     * [
     *   'content-type' => [ // Key is lowercase
     *     'name' => 'Content-Type', // Name is natural case
     *     'value' => 'application/json'
     *   ],
     *   ...
     * ]
     */
    protected array $headers = [];

    public function getHeaders(): array
    {
        $headers = [];
        foreach ($this->headers as $header) {
            $value = $this->splitCommaIfAny($header['value']);
            $headers[$header['name']] = $value;
        }
        return $headers;
    }

    public function hasHeader($name): bool
    {
        $headerKey = strtolower($name);
        return $this->headers[$headerKey] ? true : false;
    }

    /**
     * @return string[]
     */
    public function getHeader($name): array
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $headerKey = strtolower($name);
        $header = $this->headers[$headerKey];
        $headerValue = $this->splitCommaIfAny($header['value']);

        return \is_array($headerValue) ? $headerValue : [$headerValue];
    }

    public function getHeaderLine($name)
    {
        if (!$this->hasHeader($name)) {
            return '';
        }

        $headerKey = strtolower($name);

        return $this->headers[$headerKey]['value'];
    }

    public function setHeader(string $name, string $value): self
    {
        $headerKey = strtolower($name);
        $this->headers[$headerKey] = [
            'name' => $name,
            'value' => $value,
        ];
        return $this;
    }

    public function setHeaders(array $headers): self
    {
        $parsedHeaders = [];

        foreach ($headers as $name => $value) {
            $headerKey = strtolower($name);
            $parsedHeaders[$headerKey] = [
                'name' => $name,
                'value' => $value,
            ];
        }

        $this->headers = $parsedHeaders;

        return $this;
    }

    public function appendToHeader(string $name, string $value): self
    {
        $headerKey = strtolower($name);
        $existing = $this->getHeaderLine($name);
        $newValue = ($existing === '') ? $value : "{$existing},{$value}";
        $this->headers[$headerKey] = [
            'name' => $name,
            'value' => $newValue,
        ];
        return $this;
    }

    public function removeHeader(string $name): self
    {
        $headerKey = strtolower($name);
        $this->headers = Arrays::filterAssoc(
            $this->headers,
            function ($header, $key, $i) use (&$headerKey) {
                return $key !== $headerKey;
            }
        );
        return $this;
    }

    /**
     * @return string | string[]
     */
    private function splitCommaIfAny(string $value)
    {
        $hasComma = strpos($value, ',') !== false;
        return $hasComma ? explode(',', $value) : $value;
    }
}
