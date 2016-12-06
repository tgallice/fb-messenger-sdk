<?php

namespace Tgallice\FBMessenger\Model;

abstract class QuickReply implements \JsonSerializable
{
    const TYPE_TEXT = 'text';
    const TYPE_LOCATION = 'location';
    
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = [
            'type' => $this->type,
        ];

        return $json;
    }
    
    /**
     * @param string $title
     *
     * @throws \InvalidArgumentException
     */
    public static function validateTitleSize($title)
    {
        if (mb_strlen($title) > 20) {
            throw new \InvalidArgumentException('The button title field should not exceed 20 characters.');
        }
    }
    
    /**
     * @param $payload
     *
     * @throws \InvalidArgumentException
     */
    public static function validatePayload($payload)
    {
        if (mb_strlen($payload) > 1000) {
            throw new \InvalidArgumentException(sprintf('Payload should not exceed 1000 characters.', $payload));
        }
    }
}
