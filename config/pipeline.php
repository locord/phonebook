<?php
/** @var $container Container
 * @var $app Application
 */

use Engine\Http\Application;
use Engine\Http\Container\Container;
use Engine\Http\Middleware\BodyParamsMiddleware;
use Engine\Http\Middleware\ErrorMiddlewareHandler;
use Engine\Http\Middleware\RouteMiddleware;

$app->pipe($container->get(ErrorMiddlewareHandler::class));
$app->pipe($container->get(BodyParamsMiddleware::class));
$app->pipe($container->get(RouteMiddleware::class));
