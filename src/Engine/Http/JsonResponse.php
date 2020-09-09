<?php

namespace Engine\Http;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use InvalidArgumentException;

/**
 * Class JsonResponse
 * @package Engine\Http
 */
class JsonResponse extends Response
{
    /**
     * Default flags for json_encode; value of:
     *
     * <code>
     * JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES
     * </code>
     *
     * @const int
     */
    const DEFAULT_JSON_FLAGS = 79;

    /** @var StreamHelper */
    private $test;

    public function __construct($body = null, $status = 200, array $headers = ['content-type' => 'application/json'], $encodingOptions = self::DEFAULT_JSON_FLAGS)
    {
        $json = $this->jsonEncode($body, self::DEFAULT_JSON_FLAGS);
        $body = $this->createBodyFromJson($json);
        parent::__construct($status, $headers, $body);
        $this->test = new StreamHelper();
    }

    private function jsonEncode($data, $encodingOptions)
    {
        if (is_resource($data)) {
            throw new InvalidArgumentException('Cannot JSON encode resources');
        }

        // Clear json_last_error()
        json_encode(null);

        $json = json_encode($data, $encodingOptions);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException(sprintf(
                'Unable to encode data to JSON in %s: %s',
                __CLASS__,
                json_last_error_msg()
            ));
        }

        return $json;
    }

    private function createBodyFromJson($json)
    {
        $resource = StreamHelper::setStream('php://temp', 'wb+');
        $body = new Stream($resource, 'wb+');
        $body->write($json);
        $body->rewind();

        return $body;
    }
}