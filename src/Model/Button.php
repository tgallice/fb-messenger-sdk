<?php

namespace Tgallice\FBMessenger\Model;

abstract class Button implements \JsonSerializable
{
    const TYPE_POSTBACK = 'postback';
    const TYPE_PHONE_NUMBER = 'phone_number';
    const TYPE_WEB_URL = 'web_url';
    const TYPE_SHARE = 'element_share';
    const TYPE_PAYMENT = 'payment';
    const TYPE_ACCOUNT_LINK = 'account_link';
    const TYPE_ACCOUNT_UNLINK = 'account_unlink';

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
            throw new \InvalidArgumentException(sprintf(
                    'Payload should not exceed 1000 characters.', $payload)
            );
        }
    }

    /**
     * @param $phoneNumber
     *
     * @throws \InvalidArgumentException
     */
    public static function validatePhoneNumber($phoneNumber)
    {
        // Dummy phone number check
        if (strpos($phoneNumber, '+') !== 0) {
            throw new \InvalidArgumentException(sprintf(
                    'The phone number "%s" seem to be invalid. Please check the documentation to format the phone number.', $phoneNumber)
            );
        }
    }
}
