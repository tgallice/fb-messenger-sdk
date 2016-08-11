<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class WebUrl extends Button
{
    /**
     * @param string $title
     * @param string $url
     */
    public function __construct($title, $url)
    {
        parent::__construct(Button::TYPE_WEB_URL, $title, $url);
    }
}
