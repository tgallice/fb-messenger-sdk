<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;

class AccountLinkSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://www.google.com/oauth');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\AccountLink');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_ACCOUNT_LINK);
    }

    function it_has_an_url()
    {
        $this->getUrl()->shouldReturn('http://www.google.com/oauth');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => 'account_link',
            'url' => 'http://www.google.com/oauth',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
