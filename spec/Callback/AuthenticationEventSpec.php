<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Callback\Optin;

class AuthenticationEventSpec extends ObjectBehavior
{
    function let(Optin $optin)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $optin);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\AuthenticationEvent');
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

    function it_has_an_optin($optin)
    {
        $this->getOptin()->shouldReturn($optin);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('authentication_event');
    }
}
