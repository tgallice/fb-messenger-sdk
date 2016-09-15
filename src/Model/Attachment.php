<?php

namespace Tgallice\FBMessenger\Model;

use Tgallice\FBMessenger\Model\Attachment\Template;

class Attachment implements \JsonSerializable
{
    const TYPE_AUDIO = 'audio';
    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    const TYPE_TEMPLATE = 'template';

    /**
     * @var string
     */
    private $type;

    /**
     * @var array|Template
     */
    private $payload;

    /**
     * Attachment constructor.
     *
     * @param $type
     * @param array|Template $payload
     */
    public function __construct($type, $payload = [])
    {
        $this->type = $type;
        $this->payload = $payload;
    }

    /**
     * @return string
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
            'payload' => $this->payload,
        ];
    }
}
