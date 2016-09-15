<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment\Template\Receipt;

use PhpSpec\ObjectBehavior;

class ElementSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 10, 'subtitle', 1, 'currency', 'image_url');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Template\Receipt\Element');
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_should_return_the_subtitle()
    {
        $this->getSubtitle()->shouldReturn('subtitle');
    }

    function it_should_return_the_quantity()
    {
        $this->getQuantity()->shouldReturn(1);
    }

    function it_should_return_the_price()
    {
        $this->getPrice()->shouldReturn(10);
    }

    function it_should_return_the_currency()
    {
        $this->getCurrency()->shouldReturn('currency');
    }

    function it_should_return_the_image_url()
    {
        $this->getImageUrl()->shouldReturn('image_url');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'title' => 'title',
            'subtitle' => 'subtitle',
            'quantity' => 1,
            'price' => 10,
            'currency' => 'currency',
            'image_url' => 'image_url',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
