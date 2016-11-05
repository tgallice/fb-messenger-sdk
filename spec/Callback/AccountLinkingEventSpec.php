<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Callback\AccountLinking;

class AccountLinkingEventSpec extends ObjectBehavior
{
    function let(AccountLinking $accountLinking)
    {
        $this->beConstructedWith('sender_id', 'recipient_id', 123456, $accountLinking);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\AccountLinkingEvent');
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

    function it_has_an_account_linking($accountLinking)
    {
        $this->getAccountLinking()->shouldReturn($accountLinking);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('account_linking_event');
    }
}
