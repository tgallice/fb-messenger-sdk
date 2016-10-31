<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class DeliverySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(123456, 1, ['mid']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Delivery');
    }

    function it_has_a_sequence()
    {
        $this->getSequence()->shouldReturn(1);
    }

    function it_has_a_message_ids()
    {
        $this->getMessageIds()->shouldReturn(['mid']);
    }

    function it_has_a_watermark()
    {
        $this->getWatermark()->shouldReturn(123456);
    }
}
