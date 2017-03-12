<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Callback\Postback;

class PostbackEventSpec extends ObjectBehavior
{
    function let(Postback $postback)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $postback);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\PostbackEvent');
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

    function it_has_a_postback($postback)
    {
        $this->getPostback()->shouldReturn($postback);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('postback_event');
    }

    function it_has_a_postback_payload($postback)
    {
        $postback->getPayload()->willReturn('payload');
        $this->getPostbackPayload()->shouldReturn('payload');
    }

    function its_postback_referral_can_be_empty()
    {
        $this->hasPostbackReferral()->shouldReturn(false);
        $this->getPostbackReferral()->shouldReturn(null);
    }
}
