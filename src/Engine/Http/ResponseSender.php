<?php

namespace Engine\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseSender
 * @package Framework\Http
 */
class ResponseSender
{
    public function send(ResponseInterface $response)
    {
        header(sprintf(
            'HTTP/%s %d %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        echo $response->getBody()->getContents();
    }
}