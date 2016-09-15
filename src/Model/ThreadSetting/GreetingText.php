<?php

namespace Tgallice\FBMessenger\Model\ThreadSetting;

use Tgallice\FBMessenger\Model\ThreadSetting;

class GreetingText implements ThreadSetting, \JsonSerializable
{
    /**
     * @var string
     */
    private $text;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
        if (mb_strlen($text) > 160) {
            throw new \InvalidArgumentException('The greeting text should not exceed 160 characters.');
        }

        $this->text = $text;
    }

    /**
     * return array
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'text' => $this->text,
        ];
    }
}
