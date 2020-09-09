<?php

namespace Engine\Http;

use InvalidArgumentException;

/**
 * Class StreamHelper
 * @package Engine\Http
 */
class StreamHelper
{
    public static function setStream($stream, $mode = 'r')
    {
        $error    = null;
        $resource = $stream;

        if (is_string($stream)) {
            set_error_handler(function ($e) use (&$error) {
                $error = $e;
            }, E_WARNING);
            $resource = fopen($stream, $mode);
            restore_error_handler();
        }

        if ($error) {
            throw new InvalidArgumentException('Invalid stream reference provided');
        }

        if (!is_resource($resource) || 'stream' !== get_resource_type($resource)) {
            throw new InvalidArgumentException(
                'Invalid stream provided; must be a string stream identifier or stream resource'
            );
        }

        return $resource;
    }
}