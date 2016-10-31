<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class PhoneNumberSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', '+12345678');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\PhoneNumber');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_PHONE_NUMBER);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_has_a_phone_number()
    {
        $this->getPhoneNumber()->shouldReturn('+12345678');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'type' => 'phone_number',
            'title' => 'title',
            'payload' => '+12345678',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_the_title_exceed_20_characters()
    {
        $this->beConstructedWith(str_repeat('title', 5), '+12345678');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The button title field should not exceed 20 characters.'
            ))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_phone_number_have_bad_format()
    {
        $this->beConstructedWith('title', 'phone');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The phone number "phone" seem to be invalid. Please check the documentation to format the phone number.'
            ))
            ->duringInstantiation();
    }
}
