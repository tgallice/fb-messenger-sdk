<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Callback\Referral;

class ReferralEventSpec extends ObjectBehavior
{
    function let(Referral $referral)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $referral);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\ReferralEvent');
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

    function it_has_an_referral($referral)
    {
        $this->getReferral()->shouldReturn($referral);
    }
}
