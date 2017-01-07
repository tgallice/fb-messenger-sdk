<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\DefaultAction;

class DefaultActionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://www.google.com', DefaultAction::HEIGHT_RATIO_FULL, false, 'http://www.fallback.com');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\DefaultAction');
    }

    function it_has_an_url()
    {
        $this->getUrl()->shouldReturn('http://www.google.com');
    }

    function it_has_a_webview_height_ratio()
    {
        $this->getWebviewHeightRatio()->shouldReturn(DefaultAction::HEIGHT_RATIO_FULL);
    }

    function it_not_using_messenger_extensions()
    {
        $this->useMessengerExtensions()->shouldReturn(false);
    }

    function it_has_fallback_url()
    {
        $this->getFallbackUrl()->shouldReturn('http://www.fallback.com');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => 'web_url',
            'url' => 'http://www.google.com',
            'webview_height_ratio' => 'full',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_should_be_full_serializable()
    {
        $this->beConstructedWith('http://www.google.com', DefaultAction::HEIGHT_RATIO_FULL, true, 'http://www.fallback.com');
        $expected = [
            'type' => 'web_url',
            'url' => 'http://www.google.com',
            'webview_height_ratio' => 'full',
            'messenger_extensions' => true,
            'fallback_url' => 'http://www.fallback.com',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
