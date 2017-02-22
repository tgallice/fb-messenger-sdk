<?php

namespace spec\Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Client;
use Tgallice\FBMessenger\Model\Message;

class RequestOptionsFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\RequestOptionsFactory');
    }

    function it_should_create_a_multipart_option_for_file_attachment(Message $message)
    {
        $message->hasFileToUpload()->willReturn(true);
        $message->getFileStream()->willReturn('stream');
        $message->jsonSerialize()->willReturn(['data' => 'value']);

        $this::createForMessage('rid', $message, 'notif')->shouldReturn([
            RequestOptions::MULTIPART => [
                [
                    'name' => 'recipient',
                    'contents' => json_encode(['id' => 'rid']),
                ],
                [
                    'name' => 'message',
                    'contents' => json_encode(['data' => 'value']),
                ],
                [
                    'name' => 'notification_type',
                    'contents' => 'notif',
                ],
                [
                    'name' => 'filedata',
                    'contents' => 'stream',
                ]
            ],
            'timeout' => Client::DEFAULT_FILE_UPLOAD_TIMEOUT,
        ]);
    }

    function it_should_a_json_option_for_message(Message $message)
    {
        $message->hasFileToUpload()->willReturn(false);

        $this::createForMessage('rid', $message, 'notif')->shouldReturn([
            RequestOptions::JSON => [
                'recipient' => ['id' => 'rid'],
                'message' => $message,
                'notification_type' => 'notif'
            ]
        ]);
    }

    function it_should_handle_recipient_id()
    {
        $this::createRecipientField('rid')
            ->shouldReturn(['id' => 'rid']);
    }

    function it_should_handle_phone_number()
    {
        $this::createRecipientField('+1(212)555-2368')
            ->shouldReturn(['phone_number' => '+1(212)555-2368']);
    }

    function it_should_create_options_for_typing()
    {
        $this->createForTyping('USER_ID', 'status')->shouldReturn(
            [
                'json' => [
                    'recipient' => [
                        'id' => 'USER_ID',
                    ],
                    'sender_action' => 'status',
                ],
            ]
        );
    }
}
