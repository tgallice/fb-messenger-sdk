<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class ReadSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(123456, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Read');
    }

    function it_has_a_sequence()
    {
        $this->getSequence()->shouldReturn(1);
    }

    function it_has_a_watermark()
    {
        $this->getWatermark()->shouldReturn(123456);
    }
}
