<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class PhoneNumber extends Button
{
    /**
     * @param string $title
     * @param string $phoneNumber
     */
    public function __construct($title, $phoneNumber)
    {
        parent::__construct(Button::TYPE_PHONE_NUMBER, $title, $phoneNumber);
    }
}
