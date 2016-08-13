<?php

namespace Tgallice\FBMessenger\Model\ThreadSetting;

class WebUrl extends MenuItem
{
    /**
     * @param string $title
     * @param string $url
     */
    public function __construct($title, $url)
    {
        parent::__construct(MenuItem::TYPE_WEB_URL, $title, $url);
    }
}
