<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class Postback extends Button
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @param string $title
     * @param string $payload
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($title, $payload)
    {
        $this->validateTitleSize($title);

        $this->title = $title;
        $this->payload = $payload;
        $this->type = Button::TYPE_POSTBACK;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'payload' => $this->payload,
        ];
    }
}
