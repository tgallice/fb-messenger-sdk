<?php

namespace spec\Tgallice\FBMessenger\Message;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Image;
use Tgallice\FBMessenger\NotificationType;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user_id', 'text', NotificationType::REGULAR);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Message\Message');
    }

    function it_should_return_the_recipient()
    {
        $this->getRecipient()->shouldReturn('user_id');
    }

    function it_should_return_the_message()
    {
        $this->getMessageData()->shouldReturn('text');
    }

    function it_should_check_if_has_file_to_upload()
    {
        $this->hasFileToUpload()->shouldReturn(false);
    }

    function it_should_has_file_to_upload_for_image_attachment(Image $image)
    {
        $this->beConstructedWith('user_id', $image);
        $this->hasFileToUpload()->shouldReturn(true);
    }

    function it_should_handle_attachment_message(Attachment $attachment)
    {
        $this->beConstructedWith('user_id', $attachment);
        $this->getMessageData()->shouldReturn($attachment);
        $this->hasFileToUpload()->shouldReturn(false);
    }

    function it_throws_exception_if_message_text_exceed_320_characters()
    {
        $exception = new \InvalidArgumentException('The text message should not exceed 320 characters');
        $this->beConstructedWith('user_id', str_repeat('text', 100));
        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_should_return_a_formatted_message_text()
    {
        $expected = [
            'recipient' => [
                'id' => 'user_id'
            ],
            'message' => [
                'text' => 'text',
            ],
            'notification_type' => NotificationType::REGULAR,
        ];

        $this->format()->shouldBeLike($expected);
    }

    function it_should_return_a_formatted_message_with_attachment(Attachment $attachment)
    {
        $expected = [
            'recipient' => [
                'id' => 'user_id'
            ],
            'message' => [
                'attachment' => $attachment,
            ],
            'notification_type' => NotificationType::REGULAR,
        ];

        $this->beConstructedWith('user_id', $attachment);
        $this->format()->shouldBeLike($expected);
    }
}
