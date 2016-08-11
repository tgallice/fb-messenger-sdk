<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Address;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Element;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Summary;
use Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Adjustment;

class ReceiptSpec extends ObjectBehavior
{
    function let(Element $element, Summary $summary)
    {
        $this->beConstructedWith('recipient', '1a2b', 'currency', 'payment_method', [$element], $summary);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Receipt');
    }

    function it_is_a_template()
    {
        $this->shouldImplement(Template::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Template::TYPE_RECEIPT);
    }

    function it_has_a_recipient_name()
    {
        $this->getRecipientName()->shouldReturn('recipient');
    }

    function it_has_a_order_number()
    {
        $this->getOrderNumber()->shouldReturn('1a2b');
    }

    function it_has_a_currency()
    {
        $this->getCurrency()->shouldReturn('currency');
    }

    function it_has_elements($element)
    {
        $this->getElements()->shouldReturn([$element]);
    }

    function it_has_a_summary($summary)
    {
        $this->getSummary()->shouldReturn($summary);
    }

    function it_has_a_payment_method()
    {
        $this->getPaymentMethod()->shouldReturn('payment_method');
    }

    // Optionnal

    function it_has_not_default_timestamp()
    {
        $this->getTimestamp()->shouldReturn(null);
    }

    function its_timestamp_is_mutable()
    {
        $time = time();
        $this->setTimestamp($time);
        $this->getTimestamp()->shouldReturn($time);
    }

    function it_has_not_default_order_url()
    {
        $this->getOrderUrl()->shouldReturn(null);
    }

    function its_order_url_is_mutable()
    {
        $this->setOrderUrl('http://order.com');
        $this->getOrderUrl()->shouldReturn('http://order.com');
    }

    function it_has_not_default_address()
    {
        $this->getAddress()->shouldReturn(null);
    }

    function its_address_is_mutable(Address $address)
    {
        $this->setAddress($address);
        $this->getAddress()->shouldReturn($address);
    }

    function it_has_not_default_adjustments()
    {
        $this->getAdjustments()->shouldReturn(null);
    }

    function its_adjustments_are_mutable(Adjustment $adjustment)
    {
        $this->setAdjustments([$adjustment]);
        $this->getAdjustments()->shouldReturn([$adjustment]);
    }

    function it_should_be_serializable($element, $summary, Address $address, Adjustment $adjustment)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'template_type' => Template::TYPE_RECEIPT,
            'recipient_name' => 'recipient',
            'order_number' => '1a2b',
            'currency' => 'currency',
            'payment_method' => 'payment_method',
            'timestamp' => null,
            'order_url' => null,
            'elements' => [$element],
            'address' => null,
            'summary' => $summary,
            'adjustments' => [],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);

        $time = time();

        $expected = array_merge($expected, [
            'timestamp' => $time,
            'order_url' => 'http://order.com',
            'address' => $address,
            'adjustments' => [$adjustment],
        ]);

        $this->setTimestamp($time);
        $this->setOrderUrl('http://order.com');
        $this->setAddress($address);
        $this->setAdjustments([$adjustment]);

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
