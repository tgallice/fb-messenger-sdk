<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use Tgallice\FBMessenger\Attachment\Image;
use Tgallice\FBMessenger\Message\Message;

class RequestOptionsFactory
{
    /**
     * @param Message $message
     *
     * @return array
     */
    public static function create(Message $message)
    {
        $options = [];
        $formattedMessage = $message->format();

        if ($message->hasFileToUpload()) {

            /** @var Image $messageData */
            $messageData = $message->getMessageData();

            // Create a multipart request
            $options[RequestOptions::MULTIPART] = [
                [
                    'name' => 'recipient',
                    'contents' => json_encode($formattedMessage['recipient']),
                ],
                [
                    'name' => 'message',
                    'contents' => json_encode($formattedMessage['message']),
                ],
                [
                    'name' => 'notification_type',
                    'contents' => $formattedMessage['notification_type'],
                ],
                [
                    'name' => 'filedata',
                    'contents' => $messageData->open(),
                ],
            ];

            return $options;
        }

        $options[RequestOptions::JSON] = $formattedMessage;

        return $options;
    }
}
