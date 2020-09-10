<?php

namespace Engine\Http\Middleware;

use Engine\Http\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class NotFoundHandler
 * @package Engine\Http\Middleware
 */
class NotFoundHandler
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse('Undefined page', 404);
    }
}