<?php

namespace Tgallice\FBMessenger\Attachment\Template;

use Tgallice\FBMessenger\Attachment\Template;
use Tgallice\FBMessenger\Model\Address;
use Tgallice\FBMessenger\Model\Adjustment;
use Tgallice\FBMessenger\Model\Receipt\Element;
use Tgallice\FBMessenger\Model\Summary;

class Receipt extends Template
{
    const TEMPLATE_TYPE = 'receipt';

    /**
     * @param string $recipientName
     * @param string $orderNumber
     * @param string $currency
     * @param string $paymentMethod
     * @param Element[] $elements
     * @param Summary $summary
     */
    public function __construct($recipientName, $orderNumber, $currency, $paymentMethod, array $elements, Summary $summary)
    {
        $this->payload = [
            'template_type' => self::TEMPLATE_TYPE,
            'recipient_name' => $recipientName,
            'order_number' => $orderNumber,
            'currency' => $currency,
            'payment_method' => $paymentMethod,
            'timestamp' => null,
            'order_url' => null,
            'elements' => $elements,
            'address' => null,
            'summary' => $summary,
            'adjustments' => [],
        ];
    }

    /**
     * @return null|Address
     */
    public function getAddress()
    {
        return $this->payload['address'];
    }

    /**
     * @return Adjustment[]
     */
    public function getAdjustments()
    {
        return $this->payload['adjustments'];
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->payload['elements'];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->payload['currency'];
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->payload['order_number'];
    }

    /**
     * @return null|string
     */
    public function getOrderUrl()
    {
        return $this->payload['order_url'];
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payload['payment_method'];
    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->payload['recipient_name'];
    }

    /**
     * @return Summary
     */
    public function getSummary()
    {
        return $this->payload['summary'];
    }

    /**
     * @return null|string
     */
    public function getTimestamp()
    {
        return $this->payload['timestamp'];
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->payload['address'] = $address;
    }

    /**
     * @param Adjustment[] $adjustments
     */
    public function setAdjustments(array $adjustments)
    {
        $this->payload['adjustments'] = $adjustments;
    }

    /**
     * @param string $orderUrl
     */
    public function setOrderUrl($orderUrl)
    {
        $this->payload['order_url'] = $orderUrl;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->payload['timestamp'] = $timestamp;
    }
}
