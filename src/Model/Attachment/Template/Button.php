<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template;

use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Button as ButtonModel;

class Button extends Template
{
    /**
     * @var null|string
     */
    private $text;

    /**
     * @var ButtonModel[]
     */
    private $buttons;

    /**
     * @param null|string $text
     * @param ButtonModel[] $buttons
     */
    public function __construct($text, array $buttons)
    {
        $this->text = $text;
        $this->buttons = $buttons;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return Template::TYPE_BUTTON;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->getType(),
            'text' => $this->text,
            'buttons' => $this->buttons,
        ];
    }
}
