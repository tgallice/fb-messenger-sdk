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
     */
    public function __construct($url)
    {
        parent::__construct(Button::TYPE_ACCOUNT_LINK);

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['url'] = $this->url;

        return $json;
    }
}
