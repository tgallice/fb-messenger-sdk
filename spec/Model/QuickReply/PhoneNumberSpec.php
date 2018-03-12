<?php

namespace spec\Tgallice\FBMessenger\Model\QuickReply;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\QuickReply;

class PhoneNumberSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\QuickReply\PhoneNumber');
    }

    function it_is_a_quickreply()
    {
        $this->shouldImplement(QuickReply::class);
    }

    function it_has_a_content_type()
    {
        $this->getContentType()->shouldReturn(QuickReply::TYPE_USER_PHONE_NUMBER);
    }
    
    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'content_type' => 'user_phone_number'
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
