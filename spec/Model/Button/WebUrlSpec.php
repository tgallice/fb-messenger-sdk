<?php

namespace spec\Tgallice\FBMessenger\Model\Button;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Button\WebUrl;

class WebUrlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'http://www.google.com');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Button\WebUrl');
    }

    function it_is_a_button()
    {
        $this->shouldImplement(Button::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(Button::TYPE_WEB_URL);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_has_an_url()
    {
        $this->getUrl()->shouldReturn('http://www.google.com');
    }

    function it_has_a_webview_height_ratio()
    {
        $this->getWebviewHeightRatio()->shouldReturn(WebUrl::HEIGHT_RATIO_FULL);
    }

    function it_not_using_messenger_extensions()
    {
        $this->useMessengerExtensions()->shouldReturn(false);
    }
    
    function it_has_not_default_fallback_url()
    {
        $this->getFallbackUrl()->shouldReturn(null);
    }

    function its_webview_height_ratio_is_mutable()
    {
        $this->setWebviewHeightRatio(WebUrl::HEIGHT_RATIO_TALL);
        $this->getWebviewHeightRatio()->shouldReturn(WebUrl::HEIGHT_RATIO_TALL);
    }

    function its_messenger_extensions_is_mutable()
    {
        $this->setMessengerExtensions(true);
        $this->useMessengerExtensions()->shouldReturn(true);
    }

    function its_fallback_url_is_mutable()
    {
        $this->setFallbackUrl('url');
        $this->getFallbackUrl()->shouldReturn('url');
    }

    function it_throw_an_exception_if_set_an_invalid_webview_height()
    {
        $this
            ->shouldThrow(new \InvalidArgumentException('Webview height ratio must be one of this values: [full, compact, tall]'))
            ->duringSetWebviewHeightRatio('ok');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => 'web_url',
            'title' => 'title',
            'url' => 'http://www.google.com',
            'webview_height_ratio' => 'full',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_should_be_full_serializable()
    {
        $this->setMessengerExtensions(true);
        $this->setFallbackUrl('fallback url');

        $expected = [
            'type' => 'web_url',
            'title' => 'title',
            'url' => 'http://www.google.com',
            'webview_height_ratio' => 'full',
            'messenger_extensions' => true,
            'fallback_url' => 'fallback url',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_the_title_exceed_20_characters()
    {
        $this->beConstructedWith(str_repeat('title', 5), 'url');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The button title field should not exceed 20 characters.'
            ))
            ->duringInstantiation();
    }
}
