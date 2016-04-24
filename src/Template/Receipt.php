<?php

namespace Tgallice\FBMessenger\Template;

use Tgallice\FBMessenger\Model\Address;
use Tgallice\FBMessenger\Model\Adjustment;
use Tgallice\FBMessenger\Model\Receipt\Element;
use Tgallice\FBMessenger\Model\Summary;
use Tgallice\FBMessenger\Template;

class Receipt extends Template
{
    /**
     * @var Address
     */
    private $address;

    /**
     * @var Adjustment[]
     */
    private $adjustments = [];

    /**
     * @var Element[]
     */
    private $elements;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $orderNumber;

    /**
     * @var string
     */
    private $orderUrl;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var string
     */
    private $recipientName;

    /**
     * @var Summary
     */
    private $summary;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $type = Template::TYPE_RECEIPT;

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
        $this->currency = $currency;
        $this->elements = $elements;
        $this->orderNumber = $orderNumber;
        $this->paymentMethod = $paymentMethod;
        $this->summary = $summary;
        $this->recipientName = $recipientName;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Adjustment[]
     */
    public function getAdjustments()
    {
        return $this->adjustments;
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getOrderUrl()
    {
        return $this->orderUrl;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * @return Summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Address $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param Adjustment[] $adjustments
     */
    public function setAdjustments($adjustments)
    {
        $this->adjustments = $adjustments;
    }

    /**
     * @param string $orderUrl
     */
    public function setOrderUrl($orderUrl)
    {
        $this->orderUrl = $orderUrl;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function jsonSerialize()
    {
        return [
            'template_type' => $this->type,
            'recipient_name' => $this->recipientName,
            'order_number' => $this->orderNumber,
            'currency' => $this->currency,
            'payment_method' => $this->paymentMethod,
            'timestamp' => $this->timestamp,
            'order_url' => $this->orderUrl,
            'elements' => $this->elements,
            'address' => $this->address,
            'summary' => $this->summary,
            'adjustments' => $this->adjustments,
        ];
    }
}
