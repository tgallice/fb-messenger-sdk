<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;

class AddressSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('street', 'city', 'postal_code', 'state', 'country', 'second street');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Address');
    }

    function it_should_return_the_street()
    {
        $this->getStreet()->shouldReturn('street');
    }

    function it_should_return_the_city()
    {
        $this->getCity()->shouldReturn('city');
    }

    function it_should_return_the_postal_code()
    {
        $this->getPostalCode()->shouldReturn('postal_code');
    }

    function it_should_return_the_state()
    {
        $this->getState()->shouldReturn('state');
    }

    function it_should_return_the_country()
    {
        $this->getCountry()->shouldReturn('country');
    }

    function it_should_return_the_second_street()
    {
        $this->getSecondStreet()->shouldReturn('second street');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'street_1' => 'street',
            'street_2' => 'second street',
            'city' => 'city',
            'postal_code' => 'postal_code',
            'state' => 'state',
            'country' => 'country',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
