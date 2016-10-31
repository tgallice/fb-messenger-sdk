<?php

namespace spec\Tgallice\FBMessenger\Model\Callback;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Callback\CallbackEvent;

class EntrySpec extends ObjectBehavior
{
    function let(CallbackEvent $event)
    {
        $this->beConstructedWith('pageId', 123456, [$event]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Callback\Entry');
    }

    function it_has_a_page_id()
    {
        $this->getPageId()->shouldReturn('pageId');
    }

    function it_has_a_time()
    {
        $this->getTime()->shouldReturn(123456);
    }

    function it_has_an_events()
    {
        $events = $this->getCallbackEvents();
        $events[0]->shouldBeAnInstanceOf(CallbackEvent::class);
    }
}
