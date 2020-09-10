<?php

namespace Engine\Http\Middleware;

use Engine\Http\MiddlewareResolver;
use Engine\Http\Router\Exception\RequestNotMatchedException;
use Engine\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RouteMiddleware
 * @package Engine\Http\Middleware
 */
class RouteMiddleware
{
    private $router;
    private $resolver;

    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->router   = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            $result = $this->router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            $middleware = $this->resolver->resolve($result->getHandler());
            return $middleware($request, $next);
        } catch (RequestNotMatchedException $e) {
            return $next($request);
        }
    }
}