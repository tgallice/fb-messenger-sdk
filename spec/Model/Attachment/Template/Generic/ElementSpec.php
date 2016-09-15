<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template\Generic;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class ElementSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'subtitle');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Generic\Element');
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    // Optional

    function it_has_not_default_item_url()
    {
        $this->getItemUrl()->shouldReturn(null);
    }

    function its_item_url_is_mutable()
    {
        $this->setItemUrl('item_url');
        $this->getItemUrl()->shouldReturn('item_url');
    }

    function it_has_not_default_image_url()
    {
        $this->getImageUrl()->shouldReturn(null);
    }

    function its_image_url_is_mutable()
    {
        $this->setImageUrl('image_url');
        $this->getImageUrl()->shouldReturn('image_url');
    }

    function it_has_not_default_subtitle()
    {
        $this->getSubtitle()->shouldReturn(null);
    }

    function its_subtitle_is_mutable()
    {
        $this->setSubtitle('subtitle');
        $this->getSubtitle()->shouldReturn('subtitle');
    }

    function it_throws_exception_when_the_subtitle_exceed_80_characters()
    {
        $this
            ->shouldThrow(new \InvalidArgumentException('In a generic element, the "subtitle" field should not exceed 80 characters.'))
            ->duringSetSubtitle(str_repeat('subtitle', 11));
    }

    function it_has_not_default_buttons()
    {
        $this->getButtons()->shouldReturn(null);
    }

    function its_buttons_is_mutable(Button $button)
    {
        $this->setButtons([$button]);
        $this->addButton($button);
        $this->getButtons()->shouldReturn([$button, $button]);
    }

    function it_throws_exception_when_more_than_3_buttons_is_provided(Button $button)
    {
        $this
            ->shouldThrow(new \InvalidArgumentException('A generic element can not have more than 3 buttons.'))
            ->duringSetButtons([
                $button,
                $button,
                $button,
                $button,
            ]);

        $this->setButtons([
            $button,
            $button,
            $button,
        ]);

        $this
            ->shouldThrow(new \InvalidArgumentException('A generic element can not have more than 3 buttons.'))
            ->duringAddButton($button);

    }

    function it_throws_exception_when_the_title_exceed_80_characters()
    {
        $this->beConstructedWith(str_repeat('title', 20));

        $this
            ->shouldThrow(new \InvalidArgumentException('In a generic element, the "title" field should not exceed 80 characters.'))
            ->duringInstantiation();
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'title' => 'title',
            'item_url' => null,
            'image_url' => null,
            'subtitle' => null,
            'buttons' => null,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
