<?php

namespace Tgallice\FBMessenger\Model\ThreadSetting;

class Postback extends MenuItem
{
    /**
     * @param string $title
     * @param string $payload
     */
    public function __construct($title, $payload)
    {
        parent::__construct(MenuItem::TYPE_POSTBACK, $title, $payload);
    }
}

