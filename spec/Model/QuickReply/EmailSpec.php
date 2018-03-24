<?php

namespace spec\Tgallice\FBMessenger\Model\QuickReply;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\QuickReply;

class EmailSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\QuickReply\Email');
    }

    function it_is_a_quickreply()
    {
        $this->shouldImplement(QuickReply::class);
    }

    function it_has_a_content_type()
    {
        $this->getContentType()->shouldReturn(QuickReply::TYPE_USER_EMAIL);
    }
    
    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'content_type' => 'user_email'
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
