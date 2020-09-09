<?php

use Framework\Http\ResponseSender;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$request = ServerRequest::fromGlobals();

### Action
$name = $request->getQueryParams()['name'] ?: 'Guest';

### Response
/** @var Response $response */
$response = (new Response(200, [],'Hello, ' . $name . '!'))
    ->withHeader('X-Developer', 'loco');

### Sending
$emitter = new ResponseSender();
$emitter->send($response);