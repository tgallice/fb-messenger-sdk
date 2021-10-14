<?php

namespace Tgallice\FBMessenger\Callback;

use Symfony\Contracts\EventDispatcher\Event;

abstract class CallbackEvent extends Event
{
    private $senderId;
    private $recipientId;

    public function __construct($senderId, $recipientId)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
    }

    /**
     * Sender Id. Generally the User Id
     *
     * @return string
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Recipient Id. Generally the Page Id
     *
     * @return string
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * @return string
     */
    abstract public function getName();
}
