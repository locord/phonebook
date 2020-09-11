<?php

/** @var $container Container */

use App\Action\IndexAction;
use App\Action\SignUpAction;
use Engine\Http\Application;
use Engine\Http\Container\Container;
use Engine\Http\Middleware\AuthMiddleware;
use Engine\Http\Middleware\NotFoundHandler;
use Engine\Http\MiddlewareResolver;
use Engine\Http\PDOFactory;
use Engine\Http\Repositories\UserRepository;
use Engine\Http\Repositories\UserRepositoryInterface;
use Engine\Http\Router\RouteCollection;
use Engine\Http\Router\Router;
use Engine\Http\View\PhpViewRenderer;
use Engine\Http\View\ViewInterface;

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container->get(MiddlewareResolver::class),
        new NotFoundHandler()
    );
});
$container->set(PDO::class, function (Container $container) {
    $PDOFactory = new PDOFactory();
    return $PDOFactory($container);
});
$container->set(UserRepositoryInterface::class, function (Container $container) {
    return new UserRepository($container->get(PDO::class));
});
$container->set(MiddlewareResolver::class, function (Container $container) {
    return new MiddlewareResolver($container);
});
$container->set(Router::class, function () {
    // routing
    $routes = new RouteCollection();
    $routes->get('home', '/', [AuthMiddleware::class, IndexAction::class]);
    $routes->get('signup', '/signup', SignUpAction::class);
    return new Router($routes);
});
$container->set(ViewInterface::class, function () {
    return new PhpViewRenderer('views');
});