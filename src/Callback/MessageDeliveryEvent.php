<?php

namespace Tgallice\FBMessenger\Callback;

use Tgallice\FBMessenger\Model\Callback\Delivery;

class MessageDeliveryEvent extends CallbackEvent
{
    const NAME = 'message_delivery_event';

    /**
     * @var Delivery
     */
    private $delivery;

    /**
     * @param string $senderId
     * @param string $recipientId
     * @param Delivery $delivery
     */
    public function __construct($senderId, $recipientId, Delivery $delivery)
    {
        parent::__construct($senderId, $recipientId);
        $this->delivery = $delivery;
    }

    /**
     * @return Delivery
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
