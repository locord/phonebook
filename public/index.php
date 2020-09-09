<?php

use Engine\Http\ResponseSender;
use Engine\Http\Router\Exception\RequestNotMatchedException;
use Engine\Http\Router\RouteCollection;
use Engine\Http\Router\Router;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$routes = new RouteCollection();
$routes->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?: 'Guest';
    return new Response(200, [], 'Hello, ' . $name . '!');
});
$router = new Router($routes);

### Action
$request = ServerRequest::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    /** @var callable $action */
    $action   = $result->getHandler();
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new Response(404, [], 'Undefined page');
}

### Sending
$emitter = new ResponseSender();
$emitter->send($response);