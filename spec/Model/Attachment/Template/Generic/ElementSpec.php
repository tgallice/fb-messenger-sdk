<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template\Generic;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\DefaultAction;

class ElementSpec extends ObjectBehavior
{
    function let(Button $button, DefaultAction $defaultAction)
    {
        $this->beConstructedWith('title', 'subtitle', 'image_url', [$button], $defaultAction);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Generic\Element');
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_should_return_the_image_url()
    {
        $this->getImageUrl()->shouldReturn('image_url');
    }

    function it_should_return_the_buttons($button)
    {
        $this->getButtons()->shouldReturn([$button]);
    }

    function it_should_return_the_default_action($defaultAction)
    {
        $this->getDefaultAction()->shouldReturn($defaultAction);
    }

    function it_throws_exception_when_the_subtitle_exceed_80_characters()
    {
        $this->beConstructedWith('title', str_repeat('subtitle', 11));
        $this
            ->shouldThrow(new \InvalidArgumentException('In a element, the "subtitle" field should not exceed 80 characters.'))
            ->duringInstantiation();
    }

    function it_throws_exception_when_more_than_3_buttons_is_provided(Button $button)
    {
        $this->beConstructedWith('title', 'subtitle',  null, [
            $button,
            $button,
            $button,
            $button,
        ]);

        $this
            ->shouldThrow(new \InvalidArgumentException('A generic element can not have more than 3 buttons.'))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_title_exceed_80_characters()
    {
        $this->beConstructedWith(str_repeat('title', 20));

        $this
            ->shouldThrow(new \InvalidArgumentException('In a element, the "title" field should not exceed 80 characters.'))
            ->duringInstantiation();
    }

    function it_should_be_serializable($button, $defaultAction)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'title' => 'title',
            'image_url' => 'image_url',
            'subtitle' => 'subtitle',
            'buttons' => [$button],
            'default_action' => $defaultAction,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
