<?php

namespace Tgallice\FBMessenger\Model\Generic;

use Tgallice\FBMessenger\Model\Button;

class Element implements \JsonSerializable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var null|string
     */
    private $itemUrl;

    /**
     * @var null|string
     */
    private $imageUrl;

    /**
     * @var null|string
     */
    private $subtitle;

    /**
     * @var null|Button[]
     */
    private $buttons;

    /**
     * @param string $title
     * @param null|string $itemUrl
     * @param null|string $imageUrl
     * @param null|string $subtitle
     * @param null|Button[] $buttons
     */
    public function __construct($title, $itemUrl = null, $imageUrl = null, $subtitle = null, array $buttons = null)
    {
        $this->title = $title;
        $this->itemUrl = $itemUrl;
        $this->imageUrl = $imageUrl;
        $this->subtitle = $subtitle;
        $this->buttons = $buttons;

        $this->validateElement();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getItemUrl()
    {
        return $this->itemUrl;
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
     * @return null|Button[]
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
            'item_url' => $this->itemUrl,
            'image_url' => $this->imageUrl,
            'subtitle' => $this->subtitle,
            'buttons' => $this->buttons,
        ];
    }

    private function validateElement()
    {
        if (strlen($this->title) > 45) {
            throw new \InvalidArgumentException('In a generic element, the "title" field should not exceed 45 characters');
        }

        if (!empty($this->subtitle) && strlen($this->subtitle) > 80) {
            throw new \InvalidArgumentException('In a generic element, the "subtitle" field should not exceed 80 characters');
        }

        if (count($this->buttons) > 3) {
            throw new \InvalidArgumentException('A generic element can not have more than 3 buttons');
        }
    }
}
