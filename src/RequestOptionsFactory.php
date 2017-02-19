<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use Tgallice\FBMessenger\Model\Message;

class RequestOptionsFactory
{

    /**
     * @param string $recipientOrPhone
     * @param string $typingIndicator
     *
     * @return array
     */
    public static function createForTyping($recipientOrPhone, $typingIndicator) {
        $options = [];
        $data = [
            'recipient'     => self::createRecipientField($recipientOrPhone),
            'sender_action' => $typingIndicator,
        ];
        $options[RequestOptions::JSON] = $data;

        return $options;
    }

    /**
     * @param string $recipientOrPhone
     * @param Message $message
     * @param string $notificationType
     *
     * @return array
     */
    public static function createForMessage($recipientOrPhone, Message $message, $notificationType = NotificationType::REGULAR)
    {
        $options = [];
        $data = [
            'recipient' => self::createRecipientField($recipientOrPhone),
            'message' => $message,
            'notification_type' => $notificationType,
        ];
        
        if ($message->hasFileToUpload()) {

            // Create a multipart request
            $options[RequestOptions::MULTIPART] = [
                [
                    'name' => 'recipient',
                    'contents' => json_encode($data['recipient']),
                ],
                [
                    'name' => 'message',
                    'contents' => json_encode($data['message']),
                ],
                [
                    'name' => 'notification_type',
                    'contents' => $data['notification_type'],
                ],
                [
                    'name' => 'filedata',
                    'contents' => $message->getFileStream(),
                ],
            ];

            // Update timeout if we upload a file
            $options['timeout'] = Client::DEFAULT_FILE_UPLOAD_TIMEOUT;

            return $options;
        }

        $options[RequestOptions::JSON] = $data;

        return $options;
    }

    public static function createRecipientField($recipientOrPhone)
    {
        $recipientFieldName = strpos($recipientOrPhone, '+') === 0 ? 'phone_number' : 'id';

        return [$recipientFieldName => $recipientOrPhone];
    }
}
