<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Postback;
use Tgallice\FBMessenger\Model\Callback\Referral;

class PostbackEvent extends CallbackEvent
{
    const NAME = 'postback_event';

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
    public function getPostbackPayload()
    {
        return $this->postback->getPayload();
    }

    /**
     * @return boolean
     */
    public function hasPostbackReferral()
    {
        return (bool) $this->getPostback()->hasReferral();
    }

    /**
     * @return Referral|null
     */
    public function getPostbackReferral()
    {
        return $this->postback->getReferral();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
