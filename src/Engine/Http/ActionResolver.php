<?php

namespace Engine\Http;

/**
 * Class ActionResolver
 * @package Engine\Http
 */
class ActionResolver
{
    /**
     * @param $handler
     *
     * @return callable
     */
    public function resolve($handler)
    {
        return \is_string($handler) ? new $handler() : $handler;
    }
}