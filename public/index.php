<?php

use Engine\Http\HtmlResponse;
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
    return new HtmlResponse('Hello, ' . $name . '!');
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
    $handler  = $result->getHandler();
    $action   = is_string($handler) ? new $handler() : $handler;
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new HtmlResponse('Undefined page', 404);
}

### Sending
$emitter = new ResponseSender();
$emitter->send($response);