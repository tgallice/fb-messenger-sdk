<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageEchoSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(true, 'app_id', 'id', 1,  'metadata', 'text', ['attachments']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\MessageEcho');
    }

    function it_is_a_callback_message()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Model\Callback\Message');
    }

    function it_is_an_echo()
    {
        $this->isEcho()->shouldReturn(true);
    }

    function it_has_an_app_id()
    {
        $this->getAppId()->shouldReturn('app_id');
    }

    function it_has_a_metadata()
    {
        $this->getMetadata()->shouldReturn('metadata');
    }

    function its_metadata_can_be_empty()
    {
        $this->beConstructedWith(true, 'app_id', 'id', 1);
        $this->getMetadata()->shouldReturn(null);
    }
}
