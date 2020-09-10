<?php

namespace Engine\Http;

use Engine\Http\Container\Container;
use Engine\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ActionResolver
 * @package Engine\Http
 */
class MiddlewareResolver
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

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

        if (\is_string($handler) && $this->container->has($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $middleware = $this->resolve($this->container->get($handler));
                return $middleware($request, $next);
            };
        }

        if (\is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (\count($parameters) === 2 && $parameters[1]->isCallable()) {
                    return function (ServerRequestInterface $request, callable $next) use ($handler) {
                        return $handler($request, $next);
                    };
                }
                return $handler;
            }
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