<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('id', 1, 'text', ['attachment'], 'quickreply');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Message');
    }

    function it_has_an_id()
    {
        $this->getId()->shouldReturn('id');
    }

    function it_has_a_sequence()
    {
        $this->getSequence()->shouldReturn(1);
    }

    function it_has_a_text()
    {
        $this->getText()->shouldReturn('text');
    }

    function its_text_can_be_empty()
    {
        $this->beConstructedWith('id', 1, null);
        $this->hasText()->shouldReturn(false);
        $this->getText()->shouldReturn(null);
    }

    function it_has_an_attachments()
    {
        $this->getAttachments()->shouldReturn(['attachment']);
    }

    function its_attachments_can_be_empty()
    {
        $this->beConstructedWith('id', 1, null, []);
        $this->hasAttachments()->shouldReturn(false);
        $this->getAttachments()->shouldReturn([]);
    }

    function it_has_a_quick_reply()
    {
        $this->getQuickReply()->shouldReturn('quickreply');
    }

    function its_quick_reply_can_be_empty()
    {
        $this->beConstructedWith('id', 1, null, [], null);
        $this->hasQuickReply()->shouldReturn(false);
        $this->getQuickReply()->shouldReturn(null);
    }
}
