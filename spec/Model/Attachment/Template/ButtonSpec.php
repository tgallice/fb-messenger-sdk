<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Button;

class ButtonSpec extends ObjectBehavior
{
    function let(Button $button)
    {
        $this->beConstructedWith('text', [$button]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Button');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_BUTTON);
    }

    function it_has_a_text()
    {
        $this->getText()->shouldReturn('text');
    }

    function it_has_buttons($button)
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
