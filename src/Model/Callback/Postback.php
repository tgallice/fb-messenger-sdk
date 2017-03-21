<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Postback
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @var Referral|null
     */
    private $referral;

    /**
     * @param string $payload
     * @param Referral|null $referral
     */
    public function __construct($payload, Referral $referral = null)
    {
        $this->payload = $payload;
        $this->referral = $referral;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return Referral|null
     */
    public function getReferral()
    {
        return $this->referral;
    }

    /**
     * @return boolean
     */
    public function hasReferral()
    {
        return $this->referral !== null;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $referral = isset($payload['referral']) ? Referral::create($payload['referral']) : null;

        return new static($payload['payload'], $referral);
    }
}
