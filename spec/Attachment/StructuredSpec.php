<?php

namespace spec\Tgallice\FBMessenger\Attachment;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Template;

class StructuredSpec extends ObjectBehavior
{
    function let(Template $template)
    {
        $this->beConstructedWith($template);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Attachment\Structured');
    }

    function it_is_a_attachment()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Attachment');
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_TEMPLATE);
    }

    function it_should_return_the_payload($template)
    {
        $this->getPayload()->shouldReturn($template);
    }

    function it_should_be_serializable($template)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Attachment::TYPE_TEMPLATE,
            'payload' => $template,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
