<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\Receipt;

class Adjustment implements \JsonSerializable
{
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|int
     */
    private $amount;

    /**
     * @param null|string $name
     * @param null|int $amount
     */
    public function __construct($name = null, $amount = null)
    {
        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'amount' => $this->amount,
        ];
    }
}
