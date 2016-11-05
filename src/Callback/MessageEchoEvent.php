<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\MessageEcho;

class MessageEchoEvent extends CallbackEvent
{
    const NAME = 'message_echo_event';

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var MessageEcho
     */
    private $messageEcho;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param MessageEcho $messageEcho
     */
    public function __construct($senderId, $recipientId, $timestamp, MessageEcho $messageEcho)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->messageEcho = $messageEcho;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return MessageEcho
     */
    public function getMessageEcho()
    {
        return $this->messageEcho;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
