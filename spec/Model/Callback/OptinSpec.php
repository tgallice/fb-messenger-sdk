<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class OptinSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('data-ref');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Optin');
    }

    function it_has_a_ref()
    {
        $this->getRef()->shouldReturn('data-ref');
    }
}
