<?php

namespace spec\Tgallice\FBMessenger\Model\QuickReply;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\QuickReply;
use Tgallice\FBMessenger\Model\QuickReply\Location;

class LocationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\QuickReply\Location');
    }

    function it_is_a_quickreply()
    {
        $this->shouldImplement(QuickReply::class);
    }

    function it_has_a_type()
    {
        $this->getType()->shouldReturn(QuickReply::TYPE_LOCATION);
    }
    
    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);
        $expected = [
            'type' => 'location'
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
