<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class ButtonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Button::TYPE_WEB_URL, 'title', 'url');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button');
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_WEB_URL);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldBe('title');
    }

    function it_has_a_data()
    {
        $this->getData()->shouldBe('url');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_be_serialized_as_web_url_button()
    {
        $expected = [
            'type' => Button::TYPE_WEB_URL,
            'title' => 'title',
            'url' => 'url',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_should_be_serialized_as_button_with_payload()
    {
        $this->beConstructedWith(Button::TYPE_POSTBACK, 'title', 'data');
        $expected = [
            'type' => Button::TYPE_POSTBACK,
            'title' => 'title',
            'payload' => 'data',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_the_title_exceed_20_characters()
    {
        $this->beConstructedWith(Button::TYPE_POSTBACK, str_repeat('title', 5), 'payload');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The button title field should not exceed 20 characters.'
            ))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_payload_exceed_1000_characters()
    {
        $this->beConstructedWith(Button::TYPE_POSTBACK, 'title', str_repeat('a', 1001));

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'Payload should not exceed 1000 characters.'
            ))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_phone_number_have_bad_format()
    {
        $this->beConstructedWith(Button::TYPE_PHONE_NUMBER, 'title', 'phone');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The phone number "phone" seem to be invalid. Please check the documentation to format the phone number.'
            ))
            ->duringInstantiation();
    }
}
