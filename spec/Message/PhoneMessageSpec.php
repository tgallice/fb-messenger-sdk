<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\NotificationType;

class PhoneMessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('0102030405', 'text', NotificationType::REGULAR);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\PhoneMessage');
    }

    function it_is_a_message()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Message\Message');
    }

    function it_should_return_the_recipient()
    {
        $this->getRecipient()->shouldReturn('0102030405');
    }

    function it_should_return_the_message()
    {
        $this->getMessageData()->shouldReturn('text');
    }

    function it_should_handle_attachment_message(Attachment $attachment)
    {
        $this->beConstructedWith('user_id', $attachment);
        $this->getMessageData()->shouldReturn($attachment);
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
                'phone_number' => '0102030405'
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
                'phone_number' => '0102030405'
            ],
            'message' => [
                'attachment' => $attachment,
            ],
            'notification_type' => NotificationType::REGULAR,
        ];

        $this->beConstructedWith('0102030405', $attachment);
        $this->format()->shouldBeLike($expected);
    }
}
