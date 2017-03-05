<?php

namespace spec\Tgallice\FBMessenger\Model\QuickReply;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\QuickReply;
use Tgallice\FBMessenger\Model\QuickReply\Text;

class TextSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'payload');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\QuickReply\Text');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(QuickReply::class);
    }

    function it_has_a_content_type()
    {
        $this->getContentType()->shouldReturn(QuickReply::TYPE_TEXT);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn('payload');
    }
    
    function it_should_be_serializable_without_image_url()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'content_type' => 'text',
            'title' => 'title',
            'payload' => 'payload'
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_should_be_serializable_with_image_url()
    {
        $this->beConstructedWith('title', 'payload', 'image_url');
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'content_type' => 'text',
            'title' => 'title',
            'payload' => 'payload',
            'image_url' => 'image_url'
        ];
    
        $this->jsonSerialize()->shouldBeLike($expected);
    }
    
    function it_throws_exception_when_the_title_exceed_20_characters()
    {
        $this->beConstructedWith(str_repeat('title', 5), 'payload');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The button title field should not exceed 20 characters.'
            ))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_payload_exceed_1000_characters()
    {
        $this->beConstructedWith('title', str_repeat('a', 1001));

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'Payload should not exceed 1000 characters.'
            ))
            ->duringInstantiation();
    }
}
