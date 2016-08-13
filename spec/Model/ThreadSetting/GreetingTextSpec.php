<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\ThreadSetting;

class GreetingTextSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('My text');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\GreetingText');
    }

    function it_has_a_text()
    {
        $this->getText()->shouldReturn('My text');
    }

    function it_throws_exception_when_the_text_exceed_160_characters()
    {
        $this->beConstructedWith(str_repeat('x', 161));

        $this
            ->shouldThrow(new \InvalidArgumentException('The greeting text should not exceed 160 characters.'))
            ->duringInstantiation();
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'text' => 'My text',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
