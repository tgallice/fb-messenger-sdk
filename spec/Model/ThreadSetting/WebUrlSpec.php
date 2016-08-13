<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\ThreadSetting\MenuItem;

class WebUrlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'http://www.google.com');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\WebUrl');
    }

    function it_is_a_menu_item()
    {
        $this->shouldImplement(MenuItem::class);
    }
}
