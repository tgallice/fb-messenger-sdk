<?php

namespace spec\Tgallice\FBMessenger\Attachment\Structured;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Structured;
use Tgallice\FBMessenger\Attachment\Structured\Button;
use Tgallice\FBMessenger\Model\Button as ButtonModel;

class ButtonSpec extends ObjectBehavior
{
    function let(ButtonModel $button)
    {
        $this->beConstructedWith('text', [$button]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Attachment\Structured\Button');
    }

    function it_is_a_structured_attachment()
    {
        $this->shouldImplement(Structured::class);
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_TEMPLATE);
    }

    function it_should_return_the_main_text()
    {
        $this->getText()->shouldReturn('text');
    }

    function it_should_return_the_buttons($button)
    {
        $this->getButtons()->shouldReturn([$button]);
    }

    function it_should_return_the_payload($button)
    {
        $this->getPayload()->shouldReturn([
            'template_type' => Button::TEMPLATE_TYPE,
            'text' => 'text',
            'buttons' => [$button],
        ]);
    }

    function it_should_be_serializable($button)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Attachment::TYPE_TEMPLATE,
            'payload' => [
                'template_type' => Button::TEMPLATE_TYPE,
                'text' => 'text',
                'buttons' => [$button],
            ],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
