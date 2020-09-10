<?php

/** @var $container Container */

use App\Action\IndexAction;
use App\Action\SignUpAction;
use Engine\Http\Application;
use Engine\Http\Container\Container;
use Engine\Http\Middleware\BodyParamsMiddleware;
use Engine\Http\Middleware\ErrorMiddlewareHandler;
use Engine\Http\Middleware\NotFoundHandler;
use Engine\Http\Middleware\RouteMiddleware;
use Engine\Http\MiddlewareResolver;
use Engine\Http\Router\RouteCollection;
use Engine\Http\Router\Router;

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container->get(MiddlewareResolver::class),
        new NotFoundHandler()
    );
});
$container->set(MiddlewareResolver::class, function (Container $container) {
    return new MiddlewareResolver();
});
$container->set(RouteMiddleware::class, function (Container $container) {
    return new RouteMiddleware($container->get(Router::class), $container->get(MiddlewareResolver::class));
});
$container->set(Router::class, function (Container $container) {
    // routing
    $routes = new RouteCollection();
    $routes->get('home', '/', IndexAction::class);
    $routes->get('signup', '/signup', SignUpAction::class);
    return new Router($routes);
});
$container->set(ErrorMiddlewareHandler::class, function (Container $container) {
    return new ErrorMiddlewareHandler();
});
$container->set(BodyParamsMiddleware::class, function (Container $container) {
    return new BodyParamsMiddleware();
});