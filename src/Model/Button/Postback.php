<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class Postback extends Button
{
    /**
     * @var string
     */
    private $title;

    /**
     * Payload
     *
     * @var string
     */
    private $payload;

    /**
     * @param string $title
     * @param string $payload
     */
    public function __construct($title, $payload)
    {
        parent::__construct(Button::TYPE_POSTBACK);

        self::validateTitleSize($title);
        $this->title = $title;

        Button::validatePayload($payload);
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['title'] = $this->title;
        $json['payload'] = $this->payload;

        return $json;
    }
}
