<?php

namespace Engine\Http\Middleware;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BodyParamsMiddleware
 * @package Engine\Http\Middleware
 */
class BodyParamsMiddleware
{
    /**
     * @param ServerRequestInterface $request
     *
     * @param callable               $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $contentType = $request->getHeaderLine('Content-Type');

        $parts = explode(';', $contentType);
        $mime = trim(array_shift($parts));

        if (preg_match('#[/+]json$#', $mime)) {
            $rawBody = $request->getBody()->getContents();
            $parsedBody = json_decode($rawBody, true);

            if (!empty($rawBody) && json_last_error()) {
                throw new InvalidArgumentException('Error when parsing JSON request body: ' . json_last_error_msg());
            }
            return $next($request->withParsedBody($parsedBody));
        }

        return $next($request);
    }
}
