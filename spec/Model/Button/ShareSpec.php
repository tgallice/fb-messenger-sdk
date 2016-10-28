<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class ShareSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\Share');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_SHARE);
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'type' => 'element_share',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
