<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\Generic;

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
     */
    public function __construct($title)
    {
        if (mb_strlen($title) > 80) {
            throw new \InvalidArgumentException('In a generic element, the "title" field should not exceed 80 characters.');
        }

        $this->title = $title;
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
     * @param null|string $itemUrl
     */
    public function setItemUrl($itemUrl)
    {
        $this->itemUrl = $itemUrl;
    }

    /**
     * @param null|string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param null|string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        if (!empty($subtitle) && mb_strlen($subtitle) > 80) {
            throw new \InvalidArgumentException('In a generic element, the "subtitle" field should not exceed 80 characters.');
        }

        $this->subtitle = $subtitle;
    }

    /**
     * @param Button[] $buttons
     */
    public function setButtons(array $buttons)
    {
        if (count($buttons) > 3) {
            throw new \InvalidArgumentException('A generic element can not have more than 3 buttons.');
        }

        $this->buttons = $buttons;
    }

    /**
     * @param Button $button
     */
    public function addButton(Button $button)
    {
        if (count($this->buttons) >= 2 ) {
            throw new \InvalidArgumentException('A generic element can not have more than 3 buttons.');
        }

        $this->buttons[] = $button;
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
}
