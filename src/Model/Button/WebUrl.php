<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class WebUrl extends Button
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $title
     * @param string $url
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($title, $url)
    {
        $this->validateTitleSize($title);

        $this->title = $title;
        $this->url = $url;
        $this->type = Button::TYPE_WEB_URL;
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
            'title' => $this->title,
            'url' => $this->url,
        ];
    }
}
