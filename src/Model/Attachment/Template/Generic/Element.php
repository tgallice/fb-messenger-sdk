<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\Generic;

use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Attachment\Template\AbstractElement;
use Tgallice\FBMessenger\Model\DefaultAction;

class Element extends AbstractElement
{
    /**
     * @var null|DefaultAction
     */
    private $defaultAction;

    /**
     * @var null|Button[]
     */
    private $buttons;

    /**
     * @param string $title
     */
    public function __construct($title, $subtitle = null, $imageUrl = null, ?array $buttons = null, ?DefaultAction $defaultAction = null)
    {
        parent::__construct($title, $subtitle, $imageUrl);

        if (count($buttons) > 3) {
            throw new \InvalidArgumentException('A generic element can not have more than 3 buttons.');
        }

        $this->buttons = $buttons;
        $this->defaultAction = $defaultAction;
    }

    /**
     * @return null|Button[]
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @return null|DefaultAction
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'image_url' => $this->getImageUrl(),
            'subtitle' => $this->getSubtitle(),
            'buttons' => $this->buttons,
            'default_action' => $this->defaultAction,
        ];
    }
}
