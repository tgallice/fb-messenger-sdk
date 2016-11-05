<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Optin;

class AuthenticationEvent extends CallbackEvent
{
    const NAME = 'authentication_event';

    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var Optin
     */
    private $optin;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param Optin $optin
     */
    public function __construct($senderId, $recipientId, $timestamp, Optin $optin)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->optin = $optin;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return Optin
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
