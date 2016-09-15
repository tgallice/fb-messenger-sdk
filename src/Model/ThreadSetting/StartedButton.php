<?php

namespace Tgallice\FBMessenger\Model\ThreadSetting;

use Tgallice\FBMessenger\Model\ThreadSetting;

class StartedButton implements ThreadSetting, \JsonSerializable
{
    /**
     * @var string
     */
    private $payload;

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
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'payload' => $this->payload,
        ];
    }
}
