<?php

use App\Action\IndexAction;
use App\Action\SignUpAction;
use Engine\Http\MiddlewareResolver;
use Engine\Http\HtmlResponse;
use Engine\Http\Middleware\NotFoundHandler;
use Engine\Http\Pipeline\Pipeline;
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
$resolver = new MiddlewareResolver();

### Action
$request = ServerRequest::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    $handlers = $result->getHandler();
    $pipeline = new Pipeline();
    foreach (is_array($handlers) ? $handlers : [$handlers] as $handler) {
        $pipeline->pipe($resolver->resolve($handler));
    }
    $response = $pipeline($request, new NotFoundHandler());
} catch (RequestNotMatchedException $e) {
    $handler = new NotFoundHandler();
    $response = $handler($request);
}

### Sending
$emitter = new ResponseSender();
$emitter->send($response);