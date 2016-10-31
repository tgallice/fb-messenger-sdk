<?php

namespace spec\Tgallice\FBMessenger\Model\Button\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Button\Payment\PriceItem;

class PaymentSummarySpec extends ObjectBehavior
{
    function let(PriceItem $priceItem)
    {
        $this->beConstructedWith('EUR', 'FIXED_AMOUNT', 'merchant', ['shipping_address'], [$priceItem]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\Payment\PaymentSummary');
    }

    function it_has_a_currency()
    {
        $this->getCurrency()->shouldReturn('EUR');
    }

    function it_has_a_payment_type()
    {
        $this->getPaymentType()->shouldReturn('FIXED_AMOUNT');
    }

    function it_has_a_merchant_name()
    {
        $this->getMerchantName()->shouldReturn('merchant');
    }

    function it_has_a_requested_user_info()
    {
        $this->getRequestedUserInfo()->shouldReturn(['shipping_address']);
    }

    function it_has_a_price_list($priceItem)
    {
        $this->getPriceList()->shouldReturn([$priceItem]);
    }

    function it_should_be_serialized($priceItem)
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'currency' => 'EUR',
            'payment_type' => 'FIXED_AMOUNT',
            'merchant_name' => 'merchant',
            'requested_user_info' => ['shipping_address'],
            'price_list' => [$priceItem],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
