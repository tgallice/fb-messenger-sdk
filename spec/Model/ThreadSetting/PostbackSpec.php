<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\ThreadSetting\MenuItem;

class PostbackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'payload');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\Postback');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(MenuItem::class);
    }
}
