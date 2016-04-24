<?php

namespace spec\Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use PhpSpec\ObjectBehavior;
use Prophecy\Prophet;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Image;
use Tgallice\FBMessenger\Message\Message;

class RequestOptionsFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\RequestOptionsFactory');
    }

    function it_should_create_a_multipart_option_for_image_attachment(Message $message, Image $image)
    {
        $formatted = [
            'recipient' => ['recipient' => 'data'],
            'message' => ['message' => 'data'],
            'notification_type' => 'notif',
        ];

        $image->open()->willReturn('open_resource');

        $message->hasFileToUpload()->willReturn(true);
        $message->getMessageData()->willReturn($image);
        $message->format()->willReturn($formatted);

        $this::create($message)->shouldReturn([
            RequestOptions::MULTIPART => [
                [
                    'name' => 'recipient',
                    'contents' => json_encode($formatted['recipient']),
                ],
                [
                    'name' => 'message',
                    'contents' => json_encode($formatted['message']),
                ],
                [
                    'name' => 'notification_type',
                    'contents' => 'notif',
                ],
                [
                    'name' => 'filedata',
                    'contents' => 'open_resource',
                ]
            ]
        ]);
    }

    function it_should_create_body_option_attachment(Message $message)
    {
        $formatted = [
            'recipient' => [],
            'message' => [],
            'notification_type' => '',
        ];

        $message->hasFileToUpload()->willReturn(false);
        $message->format()->willReturn($formatted);

        $this::create($message)->shouldReturn([
            RequestOptions::JSON => $formatted,
        ]);
    }
}
