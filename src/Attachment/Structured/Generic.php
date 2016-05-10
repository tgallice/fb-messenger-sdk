<?php

namespace Tgallice\FBMessenger\Attachment\Structured;

use Tgallice\FBMessenger\Attachment\Structured;
use Tgallice\FBMessenger\Model\Generic\Element;

class Generic extends Structured
{
    const TEMPLATE_TYPE = 'generic';

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

        $this->payload = [
            'template_type' => self::TEMPLATE_TYPE,
            'elements' => $elements,
        ];
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->payload['elements'];
    }
}
