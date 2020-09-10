<?php

namespace Engine\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ActionResolver
 * @package Engine\Http
 */
class MiddlewareResolver
{
    /**
     * @param $handler
     *
     * @return callable
     */
    public function resolve($handler)
    {
        if (\is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }

        return $handler;
    }
}