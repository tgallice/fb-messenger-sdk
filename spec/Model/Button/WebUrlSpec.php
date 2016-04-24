<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class WebUrlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'url');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\WebUrl');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_WEB_URL);
    }

    function it_should_return_the_title()
    {
        $this->getTitle()->shouldBe('title');
    }

    function it_should_return_the_url()
    {
        $this->getUrl()->shouldBe('url');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Button::TYPE_WEB_URL,
            'title' => 'title',
            'url' => 'url',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_then_title_exceed_20_characters()
    {
        $this->beConstructedWith(str_repeat('title', 5), 'payload');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'A call to action title field should not exceed 20 characters'
            ))
            ->duringInstantiation();
    }
}
