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

        $resource = StreamHelper::setStream('php://temp', 'wb+');
        $body = new Stream($resource);
        $body->write($html);
        $body->rewind();

        return $body;
    }
}