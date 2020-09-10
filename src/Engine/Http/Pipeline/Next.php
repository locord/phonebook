<?php

namespace Engine\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Next
 * @package Engine\Http\Pipeline
 */
class Next
{
    private $queue;
    private $next;

    public function __construct(\SplQueue $queue, callable $next)
    {
        $this->queue = $queue;
        $this->next  = $next;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($this->queue->isEmpty()) {
            $next = $this->next;
            return $next($request);
        }

        $middleware = $this->queue->dequeue();

        return $middleware($request, function (ServerRequestInterface $request) {
            return $this($request);
        });
    }
}