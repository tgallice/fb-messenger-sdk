<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Attachment;

class ImageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('file.png');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\Image');
    }

    function it_is_a_file()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\File');
    }

    function it_allow_jpg_file()
    {
        $this->beConstructedWith('file.jpg');
    }

    function it_has_a_image_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_IMAGE);
    }

    function it_allow_png_file()
    {
        $this->beConstructedWith('file.png');
    }

    function it_allow_gif_file()
    {
        $this->beConstructedWith('file.gif');
    }

    function it_throws_exception_when_the_file_have_a_bad_extension()
    {
        $this->beConstructedWith('file.ext');
        $exception = new \InvalidArgumentException(
            '"file.ext" this file has not an allowed extension. Only ["jpg", "gif", "png"] extensions are supported'
        );

        $this->shouldThrow($exception)->duringInstantiation();
    }
}
