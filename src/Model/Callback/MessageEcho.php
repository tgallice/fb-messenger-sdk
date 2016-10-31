<?php

namespace Tgallice\FBMessenger\Model\Callback;

class MessageEcho extends Message
{
    /**
     * @var bool
     */
    private $isEcho;

    /**
     * @var int
     */
    private $appId;

    /**
     * @var null|string
     */
    private $metadata;

    /**
     * MessageEcho constructor.
     *
     * @param bool $isEcho
     * @param int $appId
     * @param string $id
     * @param int $sequence
     * @param null|string $metadata
     * @param null|string $text
     * @param array $attachments
     */
    public function __construct($isEcho, $appId, $id, $sequence, $metadata = null, $text = null, array $attachments = [])
    {
        parent::__construct($id, $sequence, $text, $attachments);
        $this->isEcho = $isEcho;
        $this->appId = $appId;
        $this->metadata = $metadata;
    }

    /**
     * @return boolean
     */
    public function isEcho()
    {
        return $this->isEcho;
    }

    /**
     * @return int
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return null|string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $metadata = isset($payload['metadata']) ? $payload['metadata'] : null;
        $text = isset($payload['text']) ? $payload['text'] : null;
        $attachments = isset($payload['attachments']) ? $payload['attachments'] : [];

        return new static(true, $payload['app_id'], $payload['mid'], $payload['seq'], $metadata, $text, $attachments);
    }
}
