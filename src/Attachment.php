<?php

namespace Tgallice\FBMessenger;

abstract class Attachment implements \JsonSerializable
{
    const TYPE_IMAGE = 'image';

    const TYPE_TEMPLATE = 'template';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array|Template
     */
    protected $payload;

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array|Template
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
            'type' => $this->type,
            'payload' => $this->getPayload(),
        ];
    }
}
