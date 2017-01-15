<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template;

use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\Generic\Element;

class Generic extends Template
{
    /**
     * @var Element[]
     */
    private $elements;

    /**
     * @param Element[] $elements
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $elements)
    {
        if (count($elements) > 10) {
            throw new \InvalidArgumentException('A generic template can not have more than 10 bubbles');
        }

        $this->elements = $elements;
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return Template::TYPE_GENERIC;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->getType(),
            'elements' => $this->elements,
        ];
    }
}
