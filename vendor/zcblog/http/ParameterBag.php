<?php

namespace zcblog\http;

class ParameterBag
{
    private $parameter;

    public function __construct(array $parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * Get all values of parameter.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->parameter;
    }

    /**
     * Get a value of parameter.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return array_key_exists($key, $this->parameter) ? $this->parameter[$key] : null;
    }
}
