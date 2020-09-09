<?php

namespace Engine\Http\Router;

use Engine\Http\Router\Exception\RequestNotMatchedException;
use Engine\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Router
 * @package Engine\Http\Router
 */
class Router
{
    private $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

    public function match(ServerRequestInterface $request)
    {
        foreach ($this->collection->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = [])
    {
        foreach ($this->collection->getRoutes() as $route) {
            if ($url = $route->generate($name, array_filter($params))){
                return $url;
            }
        }

        throw new RouteNotFoundException($name, $params);
    }
}