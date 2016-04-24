<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;

class MessageResponseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('recipient_id', 'message_id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\MessageResponse');
    }

    function it_should_return_recipient_id()
    {
        $this->getRecipientId()->shouldReturn('recipient_id');
    }

    function it_should_return_message_id()
    {
        $this->getMessageId()->shouldReturn('message_id');
    }
}
