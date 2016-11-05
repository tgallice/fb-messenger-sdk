<?php

namespace spec\Tgallice\FBMessenger\Callback;

use PhpSpec\ObjectBehavior;

class RawEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('sender_id', 'recipient_id', ['raw' => 'value', 'deep' => ['item' => 'valueItem']]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Callback\RawEvent');
    }

    function it_is_a_callback_event()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Callback\CallbackEvent');
    }

    function it_has_a_sender_id()
    {
        $this->getSenderId()->shouldReturn('sender_id');
    }

    function it_has_a_recipient_id()
    {
        $this->getRecipientId()->shouldReturn('recipient_id');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('raw_event');
    }

    function it_has_a_raw_event_data()
    {
        $this->getRaw()->shouldReturn(['raw' => 'value', 'deep' => ['item' => 'valueItem']]);
    }

    function it_can_get_custom_field()
    {
        $this->get('raw')->shouldReturn('value');
    }

    function it_can_get_deep_custom_field()
    {
        $this->get('deep.item')->shouldReturn('valueItem');
    }

    function it_can_get_custom_field_with_default_value()
    {
        $this->get('unknown', 'default')->shouldReturn('default');
    }
}
