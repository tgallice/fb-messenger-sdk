<?php

namespace spec\Tgallice\FBMessenger\Template;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Generic\Element;
use Tgallice\FBMessenger\Template;

class GenericSpec extends ObjectBehavior
{
    function let(Element $element)
    {
        $this->beConstructedWith([$element]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Template\Generic');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_GENERIC);
    }

    function it_should_return_the_elements($element)
    {
        $this->getElements()->shouldReturn([$element]);
    }

    function it_should_be_serializable($element)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'template_type' => Template::TYPE_GENERIC,
            'elements' => [$element],
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
