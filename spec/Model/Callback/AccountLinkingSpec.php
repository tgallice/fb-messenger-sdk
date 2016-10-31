<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class AccountLinkingSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('status', 'code');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\AccountLinking');
    }

    function it_has_a_status()
    {
        $this->getStatus()->shouldReturn('status');
    }

    function it_has_an_authorization_code()
    {
        $this->getAuthorizationCode()->shouldReturn('code');
    }

    function it_has_no_default_authorization_code()
    {
        $this->beConstructedWith('status');
        $this->getAuthorizationCode()->shouldReturn(null);
    }
}
