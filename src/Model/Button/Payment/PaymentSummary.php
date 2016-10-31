<?php

namespace Tgallice\FBMessenger\Model\Button\Payment;

class PaymentSummary implements \JsonSerializable
{
    // Payment Type
    const PAYMENT_FIXED_AMOUNT = 'FIXED_AMOUNT';
    const PAYMENT_FLEXIBLE_AMOUNT = 'FLEXIBLE_AMOUNT';

    // Requested user info
    const USER_SHIPPING_ADDRESS = 'shipping_address';
    const USER_CONTACT_NAME = 'contact_name';
    const USER_CONTACT_PHONE = 'contact_phone';
    const USER_CONTACT_EMAIL = 'contact_email';

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var string
     */
    private $merchantName;

    /**
     * @var array
     */
    private $requestedUserInfo;

    /**
     * @var array
     */
    private $priceList;

    /**
     * PaymentSummary constructor.
     *
     * @param string $currency
     * @param string $paymentType
     * @param string $merchantName
     * @param array $requestedUserInfo
     * @param PriceItem[] $priceList
     */
    public function __construct($currency, $paymentType, $merchantName, array $requestedUserInfo, array $priceList)
    {
        $this->currency = $currency;
        $this->paymentType = $paymentType;
        $this->merchantName = $merchantName;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->priceList = $priceList;
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
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return string
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }

    /**
     * @return array
     */
    public function getRequestedUserInfo()
    {
        return $this->requestedUserInfo;
    }

    /**
     * @return array
     */
    public function getPriceList()
    {
        return $this->priceList;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'currency' => $this->currency,
            'payment_type' => $this->paymentType,
            'merchant_name' => $this->merchantName,
            'requested_user_info' => $this->requestedUserInfo,
            'price_list' => $this->priceList,
        ];
    }
}
