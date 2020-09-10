<?php

use App\Action\IndexAction;
use App\Action\SignUpAction;
use Engine\Http\Application;
use Engine\Http\Middleware\BodyParamsMiddleware;
use Engine\Http\Middleware\ErrorMiddlewareHandler;
use Engine\Http\MiddlewareResolver;
use Engine\Http\Middleware\NotFoundHandler;
use Engine\Http\ResponseSender;
use Engine\Http\Router\Exception\RequestNotMatchedException;
use Engine\Http\Router\RouteCollection;
use Engine\Http\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$routes = new RouteCollection();
$routes->get('home', '/', IndexAction::class);
$routes->get('signup', '/signup', SignUpAction::class);

$router = new Router($routes);
$app    = new Application(new MiddlewareResolver(), new NotFoundHandler());

$app->pipe(ErrorMiddlewareHandler::class);
$app->pipe(BodyParamsMiddleware::class);

### Action
$request = ServerRequest::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    $app->pipe($result->getHandler());
} catch (RequestNotMatchedException $e) {
}
$response = $app->run($request);

### Sending
$emitter = new ResponseSender();
$emitter->send($response);