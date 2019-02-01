<?php

namespace zcblog\http;

/**
 * ParameterBag is a container for array.
 */
class ParameterBag
{
    /**
     * Undocumented variable.
     *
     * @var array
     */
    private $parameter;

    /**
     * Constructor.
     *
     * @param array $parameter
     */
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
