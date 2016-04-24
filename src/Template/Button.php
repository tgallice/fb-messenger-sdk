<?php

namespace Tgallice\FBMessenger\Template;

use Tgallice\FBMessenger\Template;
use Tgallice\FBMessenger\Model\Button as ButtonModel;

class Button extends Template
{
    /**
     * @var array
     */
    private $buttons;

    /**
     * @var null|string
     */
    private $text;

    /**
     * @var string
     */
    private $type = Template::TYPE_BUTTON;

    /**
     * @param null|string $text
     * @param ButtonModel[] $buttons
     */
    public function __construct($text = null, array $buttons = [])
    {
        $this->text = $text;
        $this->buttons = $buttons;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->type,
            'text' => $this->text,
            'buttons' => $this->buttons,
        ];
    }
}
