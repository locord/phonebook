<?php

namespace Engine\Http;

use Engine\Http\Pipeline\Pipeline;
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
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }

        return $handler;
    }

    private function createPipe(array $handlers)
    {
        $pipeline = new Pipeline();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}