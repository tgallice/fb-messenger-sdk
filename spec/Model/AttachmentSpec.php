<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttachmentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('type', ['payload']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment');
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn('type');
    }

    function it_has_a_payload()
    {
        $this->getPayload()->shouldReturn(['payload']);
    }

    function it_must_be_json_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => 'type',
            'payload' => ['payload'],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
