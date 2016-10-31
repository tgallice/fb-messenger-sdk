<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Postback
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @param string $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        return new static($payload['payload']);
    }
}
