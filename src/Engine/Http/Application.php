<?php

namespace Engine\Http;

use Engine\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Application
 * @package Engine\Http
 */
class Application extends Pipeline
{
    private $resolver;
    /**
     * @var callable
     */
    private $default;

    public function __construct(MiddlewareResolver $resolver, callable $default)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->default  = $default;
    }

    public function pipe($middleware)
    {
        parent::pipe($this->resolver->resolve($middleware));
    }

    public function run(ServerRequestInterface $request)
    {
        return $this($request, $this->default);
    }
}