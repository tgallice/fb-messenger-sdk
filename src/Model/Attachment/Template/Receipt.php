<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template;

use Tgallice\FBMessenger\Model\Address;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Element;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Summary;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Adjustment;

class Receipt extends Template
{
    /**
     * @var string
     */
    private $recipientName;

    /**
     * @var string
     */
    private $orderNumber;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var Element[]
     */
    private $elements;

    /**
     * @var Summary
     */
    private $summary;

    /**
     * @var null|string
     */
    private $timestamp;

    /**
     * @var null|string
     */
    private $orderUrl;

    /**
     * @var null|Address
     */
    private $address;

    /**
     * @var Adjustment[]
     */
    private $adjustments;

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
        $this->recipientName = $recipientName;
        $this->orderNumber = $orderNumber;
        $this->currency = $currency;
        $this->paymentMethod = $paymentMethod;
        $this->elements = $elements;
        $this->summary = $summary;

    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipientName;
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
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return Receipt\Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return Summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return null|string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return null|string
     */
    public function getOrderUrl()
    {
        return $this->orderUrl;
    }

    /**
     * @return null|Address
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
     * @return string
     */
    public function getType()
    {
        return Template::TYPE_RECEIPT;
    }

    /**
     * @param null|string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param null|string $orderUrl
     */
    public function setOrderUrl($orderUrl)
    {
        $this->orderUrl = $orderUrl;
    }

    /**
     * @param null|Address $address
     */
    public function setAddress(?Address $address = null)
    {
        $this->address = $address;
    }

    /**
     * @param Adjustment[] $adjustments
     */
    public function setAdjustments(array $adjustments)
    {
        $this->adjustments = $adjustments;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->getType(),
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
