<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Read;

class MessageReadEvent extends CallbackEvent
{
    const NAME = 'message_read_event';

    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var Read
     */
    private $read;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param Read $read
     */
    public function __construct($senderId, $recipientId, $timestamp, Read $read)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->read = $read;
    }

    /**
     * @return Read
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
