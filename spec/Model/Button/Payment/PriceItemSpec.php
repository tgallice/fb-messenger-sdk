<?php

namespace spec\Tgallice\FBMessenger\Model\Button\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceItemSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Subtotal', 29.99);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\Payment\PriceItem');
    }

    function it_has_a_label()
    {
        $this->getLabel()->shouldReturn('Subtotal');
    }

    function it_has_a_amount()
    {
        $this->getAmount()->shouldReturn(29.99);
    }

    function it_should_be_serialized()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'label' => 'Subtotal',
            'amount' => 29.99,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
