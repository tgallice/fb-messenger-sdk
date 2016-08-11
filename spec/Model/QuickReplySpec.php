<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuickReplySpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith('title', 'PAYLOAD');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\QuickReply');
    }

    function it_should_return_a_content_type()
    {
        $this->getContentType()->shouldReturn('text');
    }

    function it_should_return_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_should_return_a_payload()
    {
        $this->getPayload()->shouldReturn('PAYLOAD');
    }

    function It_throw_an_exception_if_payload_exceeded_character_limit()
    {
        $payload = str_repeat('x', 1001);

        $this->beConstructedWith('title', $payload);
        $this
            ->shouldThrow(new \InvalidArgumentException('$payload should not exceed 1000 characters.'))
            ->duringInstantiation();
    }

    function It_throw_an_exception_if_title_exceeded_character_limit()
    {
        $title = str_repeat('x', 21);

        $this->beConstructedWith($title, 'payload');
        $this
            ->shouldThrow(new \InvalidArgumentException('$title should not exceed 20 characters.'))
            ->duringInstantiation();
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'title' => 'title',
            'payload' => 'PAYLOAD',
            'content_type' => 'text',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
