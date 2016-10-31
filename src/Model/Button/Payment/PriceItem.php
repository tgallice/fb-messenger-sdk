<?php

namespace Tgallice\FBMessenger\Model\Button\Payment;

class PriceItem implements \JsonSerializable
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var float|int
     */
    private $amount;

    /**
     * @param string $label
     * @param float|int $amount
     */
    public function __construct($label, $amount)
    {
        $this->label = $label;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'label' => $this->label,
            'amount' => $this->amount,
        ];
    }
}
