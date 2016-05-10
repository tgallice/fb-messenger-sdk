<?php

namespace spec\Tgallice\FBMessenger\Attachment\Structured;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Structured;
use Tgallice\FBMessenger\Attachment\Structured\Generic;
use Tgallice\FBMessenger\Model\Generic\Element;

class GenericSpec extends ObjectBehavior
{
    function let(Element $element)
    {
        $this->beConstructedWith([$element]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Attachment\Structured\Generic');
    }

    function it_is_a_structured_attachment()
    {
        $this->shouldImplement(Structured::class);
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_TEMPLATE);
    }

    function it_should_return_the_elements($element)
    {
        $this->getElements()->shouldReturn([$element]);
    }

    function it_should_return_the_payload($element)
    {
        $this->getPayload()->shouldReturn([
            'template_type' => Generic::TEMPLATE_TYPE,
            'elements' => [$element],
        ]);
    }

    function it_should_be_serializable($element)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Attachment::TYPE_TEMPLATE,
            'payload' => [
                'template_type' => Generic::TEMPLATE_TYPE,
                'elements' => [$element],
            ],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_more_than_10_bubbles_per_message($elements)
    {
        $this->beConstructedWith([
            $elements, $elements, $elements, $elements, $elements,
            $elements, $elements, $elements, $elements, $elements,
            $elements,
        ]);

        $this
            ->shouldThrow(new \InvalidArgumentException('A generic template can not have more than 10 bubbles'))
            ->duringInstantiation();
    }
}
