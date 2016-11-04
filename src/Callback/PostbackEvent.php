<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Postback;

class PostbackEvent extends CallbackEvent
{
    const TYPE = 'postback_event';

    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var Postback
     */
    private $postback;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     */
    public function __construct($senderId, $recipientId, $timestamp, Postback $postback)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->postback = $postback;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return Postback
     */
    public function getPostback()
    {
        return $this->postback;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }
}
