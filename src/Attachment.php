<?php

namespace Tgallice\FBMessenger;

abstract class Attachment implements \JsonSerializable
{
    const TYPE_IMAGE = 'image';

    const TYPE_TEMPLATE = 'template';

    /**
     * @var array
     */
    protected $payload;

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => $this->getType(),
            'payload' => $this->getPayload(),
        ];
    }

    /**
     * @inheritdoc
     */
    abstract public function getType();
}
