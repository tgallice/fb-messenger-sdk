<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\Receipt;

use Tgallice\FBMessenger\Model\Attachment\Template\AbstractElement;

class Element extends AbstractElement
{
    /**
     * @var null|string
     */
    private $currency;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int|null
     */
    private $quantity;

    /**
     * @param string $title
     * @param null $price
     * @param null|string $subtitle
     * @param null|int $quantity
     * @param null|string $currency
     * @param null|string $imageUrl
     */
    public function __construct(
        $title,
        $price = 0,
        $subtitle = null,
        $quantity = null,
        $currency = null,
        $imageUrl = null
    ) {

        parent::__construct($title, $subtitle, $imageUrl);
        $this->currency = $currency;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return null|string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->getImageUrl(),
        ];
    }
}
