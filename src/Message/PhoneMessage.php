<?php

namespace Tgallice\FBMessenger\Message;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\NotificationType;

class PhoneMessage extends Message
{
    public static $recipient_value_type = 'phone_number';

    /**
     * @param string $phoneNumber
     * @param string|Attachment $messageData
     * @param string $notificationType
     */
    public function __construct($phoneNumber, $messageData, $notificationType = NotificationType::REGULAR)
    {
        parent::__construct($phoneNumber, $messageData, $notificationType);
    }
}
