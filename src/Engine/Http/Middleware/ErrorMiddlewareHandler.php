<?php

namespace Engine\Http\Middleware;

use DomainException;
use Engine\Http\JsonResponse;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ErrorMiddleware
 * @package Engine\Http\Middleware
 */
class ErrorMiddlewareHandler
{
    /**
     * @param ServerRequestInterface $request
     * @param callable               $next
     *
     * @return JsonResponse
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (DomainException $e) {
            return new JsonResponse([
                'error'   => 'error',
                'code'    => $e->getCode(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'message' => $e->getMessage(),
            ], 400);
        } catch (Exception $e) {
            return new JsonResponse([
                'error'   => 'error',
                'code'    => $e->getCode(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}