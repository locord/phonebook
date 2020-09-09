<?php

namespace Engine\Http;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

/**
 * Class HtmlResponse
 * @package Engine\Http
 */
class HtmlResponse extends Response
{
    public function __construct(
        $body = null,
        $status = 200,
        $version = '1.1',
        array $headers = ['content-type' => 'html; charset=utf-8'],
        $reason = null
    ) {
        $body = $this->createBody($body);
        parent::__construct($status, $headers, $body, $version, $reason);
    }

    private function createBody($html)
    {
        if ($html instanceof StreamInterface) {
            return $html;
        }

        if (!is_string($html)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid content (%s) provided to %s',
                (is_object($html) ? get_class($html) : gettype($html)),
                __CLASS__
            ));
        }

        $resource = $this->setStream('php://temp', 'wb+');
        $body = new Stream($resource);
        $body->write($html);
        $body->rewind();

        return $body;
    }

    private function setStream($stream, $mode = 'r')
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

        if (! is_resource($resource) || 'stream' !== get_resource_type($resource)) {
            throw new InvalidArgumentException(
                'Invalid stream provided; must be a string stream identifier or stream resource'
            );
        }

        return $resource;
    }

}