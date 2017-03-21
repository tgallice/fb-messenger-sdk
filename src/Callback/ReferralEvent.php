<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Referral;

class ReferralEvent extends CallbackEvent
{
    const NAME = 'referral_event';

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var Referral
     */
    private $referral;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param Referral $referral
     */
    public function __construct($senderId, $recipientId, $timestamp, Referral $referral)
    {
        parent::__construct($senderId, $recipientId);
        $this->timestamp = $timestamp;
        $this->referral = $referral;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return Referral
     */
    public function getReferral()
    {
        return $this->referral;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
