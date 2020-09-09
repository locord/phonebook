<?php

namespace Engine\Http\Router;

/**
 * Class Result
 * @package Engine\Http\Router
 */
class Result
{
    private $name;
    private $handler;
    private $attributes;

    /**
     * Result constructor.
     *
     * @param       $name
     * @param       $handler
     * @param array $attributes
     */
    public function __construct($name, $handler, array $attributes)
    {
        $this->name       = $name;
        $this->handler    = $handler;
        $this->attributes = $attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}