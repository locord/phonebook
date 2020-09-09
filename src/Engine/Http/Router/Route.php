<?php

namespace Engine\Http\Router;

/**
 * Class Route
 * @package Engine\Http\Router
 */
class Route
{
    public $name;
    public $pattern;
    public $handler;
    /**
     * @var array
     */
    public $methods;
    /**
     * @var array
     */
    public $tokens;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name    = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->tokens  = $tokens;
    }
}