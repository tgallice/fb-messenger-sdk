<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class PostbackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'payload');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\Postback');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }
}
