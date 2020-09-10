<?php

use Engine\Http\Container\Container;

$container = new Container();

$container->set('config', require __DIR__ . '/params.php');

require __DIR__ . '/dependencies.php';

return $container;