<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Attachment;

class AudioSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('file.mp3');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Audio');
    }

    function it_is_a_file()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\File');
    }

    function it_has_a_image_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_AUDIO);
    }
}
