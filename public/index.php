<?php

use Engine\Http\Application;
use Engine\Http\ResponseSender;
use GuzzleHttp\Psr7\ServerRequest;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$container = require 'config/container.php';
$app       = $container->get(Application::class);

### Running
require 'config/pipeline.php';
$request  = ServerRequest::fromGlobals();
$response = $app->run($request);

### Sending
$emitter = new ResponseSender();
$emitter->send($response);