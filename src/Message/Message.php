<?php

namespace Tgallice\FBMessenger\Message;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Image;
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
     * @var array
     */
    private $quickReplies;
    
    /**
     * @var string
     */
    private $notificationType;

    /**
     * @param string $recipientId Recipient Id
     * @param string|Attachment $messageData
     * @param array $quickReplies
     * @param string $notificationType
     */
    public function __construct($recipientId, $messageData, array $quickReplies = null, $notificationType = NotificationType::REGULAR)
    {
        $this->recipient = $recipientId;

        if (is_string($messageData) && mb_strlen($messageData) > 320) {
            throw new \InvalidArgumentException('The text message should not exceed 320 characters');
        }

        if(count($quickReplies) > 10) {
        	throw new \InvalidArgumentException('The quick replies should not exceed 10 elements');
        }
        
        $this->messageData = $messageData;
        $this->quickReplies = $quickReplies;
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
     * @return array
     */
    public function getQuickReplies()
    {
    	return $this->quickReplies;
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
        
		$return = [
            'recipient' => [
                $this::$recipient_value_type => $this->recipient,
            ],
            'message' => [
                $messageType => $this->messageData,
            ],
            'notification_type' => $this->notificationType,
        ];
		
		if($messageType === 'text' && count($this->quickReplies) > 0) {
			$return['quick_replies'] = $this->quickReplies;
		}
		
		return $return;
    }
}
