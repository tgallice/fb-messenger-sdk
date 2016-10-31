<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class PhoneNumber extends Button
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @param string $title
     * @param string $phoneNumber
     */
    public function __construct($title, $phoneNumber)
    {
        parent::__construct(Button::TYPE_PHONE_NUMBER);

        self::validateTitleSize($title);
        $this->title = $title;

        self::validatePhoneNumber($phoneNumber);
        $this->phoneNumber = $phoneNumber;
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
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['title'] = $this->title;
        $json['payload'] = $this->phoneNumber;

        return $json;
    }
}
