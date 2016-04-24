<?php

namespace spec\Tgallice\FBMessenger\Template;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Template;

class ButtonSpec extends ObjectBehavior
{
    function let(Button $button)
    {
        $this->beConstructedWith('text', [$button]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Template\Button');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_BUTTON);
    }

    function it_should_return_the_main_text()
    {
        $this->getText()->shouldReturn('text');
    }

    function it_should_return_the_buttons($button)
    {
        $this->getButtons()->shouldReturn([$button]);
    }

    function it_should_be_serializable($button)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'template_type' => Template::TYPE_BUTTON,
            'text' => 'text',
            'buttons' => [$button],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
