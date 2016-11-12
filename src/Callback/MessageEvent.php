<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Message;

class MessageEvent extends CallbackEvent
{
    const NAME = 'message_event';

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
     * @return null|string
     */
    public function getMessageText()
    {
        return $this->message->getText();
    }

    /**
     * @return bool
     */
    public  function isQuickReply()
    {
        return $this->message->hasQuickReply();
    }

    /**
     * @return null|string
     */
    public  function getQuickReplyPayload()
    {
        return $this->message->getQuickReply();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
