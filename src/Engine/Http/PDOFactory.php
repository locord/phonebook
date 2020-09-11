<?php

namespace Engine\Http;

use Engine\Http\Container\Container;
use PDO;
use ReflectionException;

/**
 * Class PDOFactory
 * @package Engine\Http
 */
class PDOFactory
{
    /**
     * @param Container $container
     *
     * @return PDO
     * @throws ReflectionException
     */
    public function __invoke(Container $container)
    {
        $config = $container->get('config')['pdo'];

        return new PDO(
            $config['dsn'],
            $config['username'],
            $config['password'],
            $config['options']
        );
    }
}
