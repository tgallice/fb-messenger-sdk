<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class AccountLink extends Button
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->type = Button::TYPE_ACCOUNT_LINK;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
