<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class Postback extends Button
{
    /**
     * @param string $title
     * @param string $payload
     */
    public function __construct($title, $payload)
    {
        parent::__construct(Button::TYPE_POSTBACK, $title, $payload);
    }
}
