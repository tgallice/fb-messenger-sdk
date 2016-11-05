<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Callback\Read;

class MessageReadEventSpec extends ObjectBehavior
{
    function let(Read $read)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $read);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\MessageReadEvent');
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

    function it_has_a_read($read)
    {
        $this->getRead()->shouldReturn($read);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('message_read_event');
    }
}
