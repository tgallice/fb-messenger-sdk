<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\Generic\Element;

class GenericSpec extends ObjectBehavior
{
    function let(Element $element)
    {
        $this->beConstructedWith([$element]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Generic');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_GENERIC);
    }

    function it_has_elements($element)
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
        $this->beConstructedWith(array_fill(0, 11, $elements));

        $this
            ->shouldThrow(new \InvalidArgumentException('A generic template can not have more than 10 bubbles'))
            ->duringInstantiation();
    }
}
