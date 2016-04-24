<?php

namespace Tgallice\FBMessenger\Model\Receipt;

class Element implements \JsonSerializable
{
    /**
     * @var null|string
     */
    private $currency;

    /**
     * @var null|string
     */
    private $imageUrl;

    /**
     * @var int
     */
    private $price;

    /**
     * @var int|null
     */
    private $quantity;

    /**
     * @var null|string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $title;

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

        $this->currency = $currency;
        $this->imageUrl = $imageUrl;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->subtitle = $subtitle;
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return null|string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
        ];
    }
}
