<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\ThreadSetting\MenuItem;

class MenuItemSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(MenuItem::TYPE_WEB_URL, 'title', 'url');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\MenuItem');
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(MenuItem::TYPE_WEB_URL);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldBe('title');
    }

    function it_has_a_data()
    {
        $this->getData()->shouldBe('url');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_be_serialized_as_web_url_menu_item()
    {
        $expected = [
            'type' => MenuItem::TYPE_WEB_URL,
            'title' => 'title',
            'url' => 'url',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_should_be_serialized_as_menu_item_with_payload()
    {
        $this->beConstructedWith(MenuItem::TYPE_POSTBACK, 'title', 'data');
        $expected = [
            'type' => MenuItem::TYPE_POSTBACK,
            'title' => 'title',
            'payload' => 'data',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_when_the_title_exceed_30_characters()
    {
        $this->beConstructedWith(MenuItem::TYPE_POSTBACK, str_repeat('title', 10), 'payload');

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'The menu item title field should not exceed 30 characters.'
            ))
            ->duringInstantiation();
    }

    function it_throws_exception_when_the_payload_exceed_1000_characters()
    {
        $this->beConstructedWith(MenuItem::TYPE_POSTBACK, 'title', str_repeat('a', 1001));

        $this
            ->shouldThrow(new \InvalidArgumentException(
                'Payload should not exceed 1000 characters.'
            ))
            ->duringInstantiation();
    }
}
