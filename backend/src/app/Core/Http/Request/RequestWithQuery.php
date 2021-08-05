<?php

namespace App\Core\Http\Request;

trait RequestWithQuery
{
    protected array $query = [];

    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Ex.:
     * - 'a=1&b2=' => ['a' => '1', 'b' => '2']
     * - 'a[]=11&a[]=22&b=3' => ['a' => ['11', '22'], 'b' => '3']
     *
     * @param string $queryString
     * @return self
     */
    public function setQuery($queryString): self
    {
        $parsedQueryString = [];
        parse_str($queryString, $parsedQueryString);
        $this->query = $parsedQueryString;

        return $this;
    }
}
