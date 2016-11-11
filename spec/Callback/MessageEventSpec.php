<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Callback\Message;

class MessageEventSpec extends ObjectBehavior
{
    function let(Message $message)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $message);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\MessageEvent');
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

    function it_has_a_message($message)
    {
        $this->getMessage()->shouldReturn($message);
    }

    function it_has_a_message_text($message)
    {
        $message->getText()->willReturn('text');
        $this->getMessageText()->shouldReturn('text');
    }

    function it_can_check_if_it_is_a_quick_reply($message)
    {
        $message->hasQuickReply()->willReturn(true);
        $this->isQuickReply()->shouldReturn(true);
    }

    function it_has_a_quick_reply_payload($message)
    {
        $message->getQuickReply()->willReturn('quick_reply');
        $this->getQuickReplyPayload()->shouldReturn('quick_reply');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('message_event');
    }
}
