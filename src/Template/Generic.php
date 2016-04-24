<?php

namespace Tgallice\FBMessenger\Template;

use Tgallice\FBMessenger\Model\Generic\Element;
use Tgallice\FBMessenger\Template;

class Generic extends Template
{
    /**
     * @var Element[]
     */
    private $elements;

    /**
     * @var string
     */
    private $type = Template::TYPE_GENERIC;

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
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->type,
            'elements' => $this->elements,
        ];
    }
}
