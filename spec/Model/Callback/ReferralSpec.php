<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class ReferralSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('my-ref', 'source', 'type');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Referral');
    }

    function it_has_a_ref()
    {
        $this->getRef()->shouldReturn('my-ref');
    }

    function it_has_a_source()
    {
        $this->getSource()->shouldReturn('source');
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn('type');
    }
}
