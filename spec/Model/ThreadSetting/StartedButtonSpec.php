<?php

namespace spec\Tgallice\FBMessenger\Model\ThreadSetting;

use PhpSpec\ObjectBehavior;

class StartedButtonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user_payload');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\ThreadSetting\StartedButton');
    }

    function it_is_a_thread_setting()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Model\ThreadSetting');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn('user_payload');
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'payload' => 'user_payload',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
