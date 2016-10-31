<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Button\Payment\PaymentSummary;

class PaymentSpec extends ObjectBehavior
{
    function let(PaymentSummary $summary)
    {
        $this->beConstructedWith('my_payload', $summary);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\Payment');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_PAYMENT);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('buy');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn('my_payload');
    }

    function it_has_a_payment_summary($summary)
    {
        $this->getPaymentSummary()->shouldReturn($summary);
    }

    function it_should_be_serializable($summary)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => 'payment',
            'title' => 'buy',
            'payload' => 'my_payload',
            'payment_summary' => $summary,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
