<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template\ElementList;

use Tgallice\FBMessenger\Model\Attachment\Template\AbstractElement;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\DefaultAction;

class Element extends AbstractElement
{
    /**
     * @var null|Button
     */
    private $button;

    /**
     * @var null|DefaultAction
     */
    private $defaultAction;

    /**
     * @param string $title
     * @param null|string $subtitle
     * @param null|string $imageUrl
     * @param Button|null $button
     * @param DefaultAction|null $defaultAction
     */
    public function __construct($title, $subtitle = null, $imageUrl = null, ?Button $button = null, ?DefaultAction $defaultAction = null)
    {
        parent::__construct($title, $subtitle, $imageUrl);
        $this->button = $button;
        $this->defaultAction = $defaultAction;
    }

    public function getButton()
    {
        return $this->button;
    }

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
            'subtitle' => $this->getSubtitle(),
            'image_url' => $this->getImageUrl(),
            'buttons' => $this->button ? [$this->button] : null,
            'default_action' => $this->defaultAction,
        ];
    }
}
