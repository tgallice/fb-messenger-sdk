<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Button\Payment\PaymentSummary;

class Payment extends Button
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var PaymentSummary
     */
    private $paymentSummary;

    /**
     * @param string $payload
     * @param PaymentSummary $paymentSummary
     */
    public function __construct($payload, PaymentSummary $paymentSummary)
    {
        parent::__construct(Button::TYPE_PAYMENT);

        $this->title = 'buy'; // Title must be buy.
        $this->payload = $payload;
        $this->paymentSummary = $paymentSummary;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return PaymentSummary
     */
    public function getPaymentSummary()
    {
        return $this->paymentSummary;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['title'] = $this->title;
        $json['payload'] = $this->payload;
        $json['payment_summary'] = $this->paymentSummary;

        return $json;
    }

}
