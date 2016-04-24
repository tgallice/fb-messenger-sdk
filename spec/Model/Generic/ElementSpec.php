<?php

namespace spec\Tgallice\FBMessenger\Model\Generic;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Template\Button;

class ElementSpec extends ObjectBehavior
{
    function let(Button $button)
    {
        $buttons = [
            $button
        ];

        $this->beConstructedWith('title', 'item_url', 'image_url', 'subtitle', $buttons);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Generic\Element');
    }

    function it_should_return_the_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_should_return_the_item_url()
    {
        $this->getItemUrl()->shouldReturn('item_url');
    }

    function it_should_return_the_subtitle()
    {
        $this->getSubtitle()->shouldReturn('subtitle');
    }

    function it_should_return_the_buttons($button)
    {
        $this->getButtons()->shouldReturn([$button]);
    }

    function it_throws_exception_when_more_than_3_buttons_is_provide($button)
    {
        $this->beConstructedWith('title', 'item_url', 'image_url', 'subtitle', [
            $button,
            $button,
            $button,
            $button,
        ]);

        $this
            ->shouldThrow(new \InvalidArgumentException('A generic element can not have more than 3 buttons'))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_title_exceed_45_characters()
    {
        $this->beConstructedWith(str_repeat('title', 10));

        $this
            ->shouldThrow(new \InvalidArgumentException('In a generic element, the "title" field should not exceed 45 characters'))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_subtitle_exceed_80_characters()
    {
        $this->beConstructedWith('title', null, null, str_repeat('subtitle', 11));

        $this
            ->shouldThrow(new \InvalidArgumentException('In a generic element, the "subtitle" field should not exceed 80 characters'))
            ->duringInstantiation();
    }

    function it_should_return_the_image_url()
    {
        $this->getImageUrl()->shouldReturn('image_url');
    }

    function it_should_be_serializable($button)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'title' => 'title',
            'item_url' => 'item_url',
            'image_url' => 'image_url',
            'subtitle' => 'subtitle',
            'buttons' => [$button],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
