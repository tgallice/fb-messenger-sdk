<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Callback\Delivery;

class MessageDeliveryEventSpec extends ObjectBehavior
{
    function let(Delivery $delivery)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', $delivery);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\MessageDeliveryEvent');
    }

    function it_has_a_sender_id()
    {
        $this->getSenderId()->shouldReturn('sender_id');
    }

    function it_has_a_recipient_id()
    {
        $this->getRecipientId()->shouldReturn('recipient_id');
    }

    function it_has_a_delivery($delivery)
    {
        $this->getDelivery()->shouldReturn($delivery);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('message_delivery_event');
    }
}
