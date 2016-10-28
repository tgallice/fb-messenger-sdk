<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class Share extends Button
{
    public function __construct()
    {
        parent::__construct(Button::TYPE_SHARE);
    }
}
