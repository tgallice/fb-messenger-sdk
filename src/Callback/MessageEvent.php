<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Message;

class MessageEvent extends CallbackEvent
{
    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var Message
     */
    private $message;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param Message $message
     */
    public function __construct($senderId, $recipientId, $timestamp, Message $message)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'message_event';
    }
}
