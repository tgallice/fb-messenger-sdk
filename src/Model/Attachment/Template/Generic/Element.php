<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\Generic;

use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Attachment\Template\AbstractElement;

class Element extends AbstractElement
{
    /**
     * @var null|string
     */
    private $itemUrl;

    /**
     * @var null|Button[]
     */
    private $buttons;

    /**
     * @param string $title
     */
    public function __construct($title, $subtitle = null, $imageUrl = null, $itemUrl = null, $buttons = null)
    {
        parent::__construct($title, $subtitle, $imageUrl);

        $this->itemUrl = $itemUrl;

        if (count($buttons) > 3) {
            throw new \InvalidArgumentException('A generic element can not have more than 3 buttons.');
        }

        $this->buttons = $buttons;
    }

    /**
     * @return null|string
     */
    public function getItemUrl()
    {
        return $this->itemUrl;
    }

    /**
     * @return null|Button[]
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @deprecated use the constructor argument instead
     * @param null|string $itemUrl
     */
    public function setItemUrl($itemUrl)
    {
        $this->itemUrl = $itemUrl;
    }

    /**
     * @deprecated use the constructor argument instead
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
     * @deprecated use the constructor argument instead
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
            'title' => $this->getTitle(),
            'item_url' => $this->itemUrl,
            'image_url' => $this->getImageUrl(),
            'subtitle' => $this->getSubtitle(),
            'buttons' => $this->buttons,
        ];
    }
}
