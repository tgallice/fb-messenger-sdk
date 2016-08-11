<?php

namespace Tgallice\FBMessenger\Model;

class Button implements \JsonSerializable
{
    const TYPE_POSTBACK = 'postback';
    const TYPE_PHONE_NUMBER = 'phone_number';
    const TYPE_WEB_URL = 'web_url';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * Url or payload
     *
     * @var string
     */
    protected $data;

    /**
     * @param string $type
     * @param string $title
     * @param string $data Url, phone number or payload value
     */
    public function __construct($type, $title, $data)
    {
        $this->type = $type;

        $this->validateTitleSize($title);
        $this->title = $title;

        if ($this->type === self::TYPE_POSTBACK) {
            $this->validatePayload($data);
        } elseif ($this->type === self::TYPE_PHONE_NUMBER) {
            $this->validatePhoneNumber($data);
        }

        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $data = [
            'type' => $this->type,
            'title' => $this->title,
        ];

        if ($this->type === self::TYPE_WEB_URL) {
            $data['url'] = $this->data;
        } else {
            $data['payload'] = $this->data;
        }

        return $data;
    }

    /**
     * @param string $title
     *
     * @throws \InvalidArgumentException
     */
    private function validateTitleSize($title)
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
    private function validatePayload($payload)
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
    private function validatePhoneNumber($phoneNumber)
    {
        // Dummy phone number check
        if (strpos($phoneNumber, '+') !== 0) {
            throw new \InvalidArgumentException(sprintf(
                    'The phone number "%s" seem to be invalid. Please check the documentation to format the phone number.', $phoneNumber)
            );
        }
    }
}
