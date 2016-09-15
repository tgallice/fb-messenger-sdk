<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class PhoneNumberSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', '+12345678');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\PhoneNumber');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }
}
