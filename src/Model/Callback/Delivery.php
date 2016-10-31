<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Delivery
{
    /**
     * @var int
     */
    private $sequence;

    /**
     * @var array
     */
    private $messageIds;

    /**
     * @var int
     */
    private $watermark;

    /**
     * @param int $watermark
     * @param int $sequence
     * @param array $messageIds
     */
    public function __construct($watermark, $sequence, array $messageIds = [])
    {
        $this->watermark = $watermark;
        $this->sequence = $sequence;
        $this->messageIds = $messageIds;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @return int
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * @return array
     */
    public function getMessageIds()
    {
        return $this->messageIds;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $mids = isset($payload['mids']) ? $payload['mids'] : [];
        return new static($payload['watermark'], $payload['seq'], $mids);
    }
}
