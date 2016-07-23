<?php

namespace Tgallice\FBMessenger\Message;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Image;
use Tgallice\FBMessenger\Model\QuickReply;
use Tgallice\FBMessenger\NotificationType;

class Message
{
    public static $recipient_value_type = 'id';

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string|Attachment
     */
    private $messageData;

    /**
     * @var null|QuickReply[]
     */
    private $quickReplies;

    /**
     * @var null|string
     */
    private $metadata;

    /**
     * @var string
     */
    private $notificationType;

    /**
     * @param string $recipientId Recipient Id
     * @param string|Attachment $messageData
     * @param null|QuickReply|QuickReply[] $quickReplies
     * @param null|string $metadata
     * @param string $notificationType
     */
    public function __construct($recipientId, $messageData, $quickReplies = null, $metadata = null, $notificationType = NotificationType::REGULAR)
    {
        $this->recipient = $recipientId;

        if (is_string($messageData) && mb_strlen($messageData) > 320) {
            throw new \InvalidArgumentException('The text message should not exceed 320 characters');
        }

        if (!is_string($messageData) && !$messageData instanceOf Attachment) {
            throw new \InvalidArgumentException('The message date must be a string or an Attachment.');
        }

        if ($metadata !== null && mb_strlen($metadata) > 1000) {
            throw new \InvalidArgumentException('$metadata should not exceed 1000 characters.');
        }

        $this->messageData = $messageData;
        $this->quickReplies = $this->initializeQuickReplies($quickReplies);
        $this->metadata = $metadata;
        $this->notificationType = $notificationType;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return string|Attachment
     */
    public function getMessageData()
    {
        return $this->messageData;
    }


    /**
     * @return null|QuickReply[]
     */
    public function getQuickReplies()
    {
        return $this->quickReplies;
    }

    /**
     * @return null|string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * @return bool
     */
    public function hasFileToUpload()
    {
        return $this->messageData instanceof Image && !$this->messageData->isRemoteFile();
    }

    /**
     * Return the formatted message
     *
     * @return array
     */
    public function format()
    {
        $messageType = is_string($this->messageData) ? 'text' : 'attachment';

        return [
            'recipient' => [
                $this::$recipient_value_type => $this->recipient,
            ],
            'message' => [
                $messageType => $this->messageData,
                'quick_replies' => $this->quickReplies,
                'metadata' => $this->metadata,
            ],
            'notification_type' => $this->notificationType,
        ];
    }

    /**
     * @param null|QuickReply|QuickReply[] $quickReplies
     *
     * @return null|QuickReply[]
     */
    private function initializeQuickReplies($quickReplies = null)
    {
        if ($quickReplies instanceof QuickReply) {
            $quickReplies = [$quickReplies];
        } elseif ($quickReplies !== null && !is_array($quickReplies)) {
            throw new \InvalidArgumentException('$quickReplies must be an array of QuickReply, a QuickReply or a null value.');
        } elseif (count($quickReplies) > 10) {
            throw new \InvalidArgumentException('A message can not have more than 10 quick replies.');
        }

        return $quickReplies;
    }
}
