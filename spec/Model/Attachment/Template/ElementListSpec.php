<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\ElementList;
use Tgallice\FBMessenger\Model\Attachment\Template\ElementList\Element;
use Tgallice\FBMessenger\Model\Button;

class ElementListSpec extends ObjectBehavior
{
    function let(Element $element, Button $button)
    {
        $element->getImageUrl()->willReturn('http://test.com/image.png');
        $this->beConstructedWith([$element, $element], $button);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\ElementList');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_LIST);
    }

    function it_has_elements($element)
    {
        $this->getElements()->shouldReturn([$element, $element]);
    }

    function it_has_a_top_element_style()
    {
        $this->getTopElementStyle()->shouldReturn('large');
    }

    function its_element_style_can_be_compact($element)
    {
        $this->beConstructedWith([$element, $element], null, ElementList::TOP_STYLE_COMPACT);
        $this->getTopElementStyle()->shouldReturn('compact');
    }

    // Optionnal

    function it_has_not_default_button($element)
    {
        $this->beConstructedWith([$element, $element]);
        $this->getButton()->shouldReturn(null);
    }

    // exceptions

    function it_must_raise_an_exception_if_top_element_style_is_large_and_no_image_set_in_first_element(
        $element, Button $button
    )
    {
        $element->getImageUrl()->willReturn(null);
        $this->beConstructedWith([$element], $button);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_must_raise_an_exception_if_less_than_2_elements_is_defined($element, Button $button)
    {
        $this->beConstructedWith([$element], $button);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_must_raise_an_exception_if_more_than_4_elements_is_defined($element, Button $button)
    {
        $this->beConstructedWith([$element,$element,$element,$element,$element], $button);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_be_serializable($element, $button)
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'template_type' => 'list',
            'top_element_style' => 'large',
            'elements' => [$element, $element],
            'buttons' => [$button],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
