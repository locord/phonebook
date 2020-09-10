<?php

namespace Engine\Http;

use Engine\Http\Pipeline\Pipeline;

/**
 * Class Application
 * @package Engine\Http
 */
class Application extends Pipeline
{
    private $resolver;

    public function __construct(MiddlewareResolver $resolver)
    {
        parent::__construct();
        $this->resolver = $resolver;
    }

    public function pipe($middleware)
    {
        parent::pipe($this->resolver->resolve($middleware));
    }
}