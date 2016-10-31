<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Read
{
    /**
     * @var int
     */
    private $watermark;
    /**
     * @var int
     */
    private $sequence;

    /**
     * @param int $watermark
     * @param int $sequence
     */
    public function __construct($watermark, $sequence)
    {
        $this->watermark = $watermark;
        $this->sequence = $sequence;
    }

    /**
     * @return int
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        return new static($payload['watermark'], $payload['seq']);
    }
}
