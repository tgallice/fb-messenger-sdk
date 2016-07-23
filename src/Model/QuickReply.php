<?php

namespace Tgallice\FBMessenger\Model;

class QuickReply
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $contentType = 'text';

    /**
     * @param string $title
     * @param string $payload
     */
    public function __construct($title, $payload)
    {
        if (empty($title) || mb_strlen($title) > 20) {
            throw new \InvalidArgumentException('$title should not exceed 20 characters.');
        }
        if (empty($payload) || mb_strlen($payload) > 1000) {
            throw new \InvalidArgumentException('$payload should not exceed 1000 characters.');
        }

        $this->title = $title;
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
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
}
