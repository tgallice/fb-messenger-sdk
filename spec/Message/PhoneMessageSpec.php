<?php

namespace spec\Tgallice\FBMessenger\Message;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Model\QuickReply;
use Tgallice\FBMessenger\NotificationType;

class PhoneMessageSpec extends ObjectBehavior
{
    function let(QuickReply $quickReply)
    {
        $this->beConstructedWith('0102030405', 'text', $quickReply, 'metadata', NotificationType::REGULAR);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Message\PhoneMessage');
    }

    function it_is_a_message()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Message\Message');
    }

    function it_should_return_the_recipient()
    {
        $this->getRecipient()->shouldReturn('0102030405');
    }

    function it_should_return_a_formatted_message_text($quickReply)
    {
        $expected = [
            'recipient' => [
                'phone_number' => '0102030405'
            ],
            'message' => [
                'text' => 'text',
                'quick_replies' => [$quickReply],
                'metadata' => 'metadata',
            ],
            'notification_type' => NotificationType::REGULAR,
        ];

        $this->format()->shouldBeLike($expected);
    }

    function it_should_return_a_formatted_message_with_attachment(Attachment $attachment, $quickReply)
    {

        $expected = [
            'recipient' => [
                'phone_number' => '0102030405'
            ],
            'message' => [
                'attachment' => $attachment,
                'quick_replies' => [$quickReply],
                'metadata' => 'metadata',
            ],
            'notification_type' => NotificationType::REGULAR,
        ];

        $this->beConstructedWith('0102030405', $attachment, $quickReply, 'metadata');
        $this->format()->shouldBeLike($expected);
    }
}
