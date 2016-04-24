<?php

namespace Tgallice\FBMessenger\Model;

class MessageResponse
{
    /**
     * @var string
     */
    private $recipientId;

    /**
     * @var string
     */
    private $messageId;

    /**
     * @param string $recipientId
     * @param string $messageId
     */
    public function __construct($recipientId, $messageId)
    {
        $this->recipientId = $recipientId;
        $this->messageId = $messageId;
    }

    /**
     * @return string
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }
}
