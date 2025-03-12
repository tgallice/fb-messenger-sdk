<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\MessageDelete;

class MessageDeleteEvent extends CallbackEvent
{
    const NAME = 'message_delete_event';

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var MessageEcho
     */
    private $messageDelete;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param MessageEcho $messageEcho
     */
    public function __construct($senderId, $recipientId, $timestamp, MessageDelete $messageDelete)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->messageDelete = $messageDelete;
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
    public function getMessageDelete()
    {
        return $this->messageDelete;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
