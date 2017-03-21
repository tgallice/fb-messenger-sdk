<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Callback\Referral;

class PostbackSpec extends ObjectBehavior
{
    function let(Referral $referral)
    {
        $this->beConstructedWith('my-payload', $referral);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Postback');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn('my-payload');
    }

    function it_has_a_referral()
    {
        $referral = $this->getReferral();
        $referral->shouldBeAnInstanceOf(Referral::class);
    }

    function its_referral_can_be_empty()
    {
        $this->beConstructedWith('my-payload', null);
        $this->hasReferral()->shouldReturn(false);
        $this->getReferral()->shouldReturn(null);
    }
}
