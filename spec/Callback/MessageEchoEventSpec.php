<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Callback\MessageEcho;

class MessageEchoEventSpec extends ObjectBehavior
{
    function let(MessageEcho $messageEcho)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $messageEcho);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\MessageEchoEvent');
    }

    function it_is_a_callback_event()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Callback\CallbackEvent');
    }

    function it_has_a_sender_id()
    {
        $this->getSenderId()->shouldReturn('sender_id');
    }

    function it_has_a_recipient_id()
    {
        $this->getRecipientId()->shouldReturn('recipient_id');
    }

    function it_has_a_timestamp()
    {
        $this->getTimeStamp()->shouldReturn(123456);
    }

    function it_has_a_message_echo($messageEcho)
    {
        $this->getMessageEcho()->shouldReturn($messageEcho);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('message_echo_event');
    }
}
