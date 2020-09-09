<?php

use App\Action\CabinetAction;
use App\Action\IndexAction;
use App\Action\SignUpAction;
use Engine\Http\ActionResolver;
use Engine\Http\HtmlResponse;
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
$resolver = new ActionResolver();

### Action
$request = ServerRequest::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler  = $result->getHandler();
    $action   = $resolver->resolve($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new HtmlResponse('Undefined page', 404);
}

### Sending
$emitter = new ResponseSender();
$emitter->send($response);