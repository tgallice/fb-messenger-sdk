<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class PostbackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('my-payload');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Postback');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn('my-payload');
    }
}
