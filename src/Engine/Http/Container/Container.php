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

    public function get($id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }

        $definition = $this->definitions[$id];

        if ($definition instanceof \Closure) {
            $result = $definition();
        } else {
            $result = $definition;
        }

        return $result;
    }

    public function set($id, $value)
    {
        $this->definitions[$id] = $value;
    }
}