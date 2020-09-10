<?php

namespace Engine\Http\Container;

use Engine\Http\Container\Exception\ServiceNotFoundException;

/**
 * Class Container
 * @package Engine\Http\Container
 */
class Container
{
    private $definitions = [];
    private $results = [];

    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }
        if (!array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }

        $definition = $this->definitions[$id];

        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } else {
            $this->results[$id] = $definition;

        }

        return $this->results[$id];
    }

    public function set($id, $value)
    {
        $this->definitions[$id] = $value;
    }
}