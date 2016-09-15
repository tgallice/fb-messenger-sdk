<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template\Receipt;

use PhpSpec\ObjectBehavior;

class AdjustmentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('name', 100);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Adjustment');
    }

    function it_should_return_the_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_should_return_the_amount()
    {
        $this->getAmount()->shouldReturn(100);
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'name' => 'name',
            'amount' => 100,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
