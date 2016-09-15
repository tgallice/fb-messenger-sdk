<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template\Receipt;

use PhpSpec\ObjectBehavior;

class SummarySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(100, 20, 70, 10);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Summary');
    }

    function it_should_return_the_total_cost()
    {
        $this->getTotalCost()->shouldReturn(100);
    }

    function it_should_return_the_subtotal()
    {
        $this->getSubTotal()->shouldReturn(70);
    }

    function it_should_return_the_shipping_cost()
    {
        $this->getShippingCost()->shouldReturn(10);
    }

    function it_should_return_the_total_tax()
    {
        $this->getTotalTax()->shouldReturn(20);
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'subtotal' => 70,
            'shipping_cost' => 10,
            'total_tax' => 20,
            'total_cost' => 100,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
