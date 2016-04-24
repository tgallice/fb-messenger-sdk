<?php

namespace spec\Tgallice\FBMessenger\Attachment;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;

class ImageSpec extends ObjectBehavior
{
    private $_filename;

    function let()
    {
        $this->generateFile('.png');
        $this->beConstructedWith($this->_filename);
    }

    function letGo()
    {
        unlink($this->_filename);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Attachment\Image');
    }

    function it_is_a_attachment()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Attachment');
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_IMAGE);
    }

    function it_should_return_the_file_path()
    {
        $this->getPath()->shouldReturn($this->_filename);
    }

    function it_should_return_a_empty_payload()
    {
        $this->getPayload()->shouldReturn([]);
    }

    function it_allow_jpg_local_file()
    {
        $this->generateFile('.jpg');

        $this->beConstructedWith($this->_filename);
    }

    function it_throws_exception_when_the_file_is_not_a_png_or_a_jpg()
    {
        $this->generateFile('.ext');

        $this->beConstructedWith($this->_filename);
        $exception = new \InvalidArgumentException(
            sprintf('"%s" this file has not a allowed extension. Only "png" and "jpg" image are supported', $this->_filename)
        );

        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_throws_exception_when_the_local_file_is_not_readable()
    {
        $this->generateFile('.jpg', false);

        $exception = new \InvalidArgumentException(
            sprintf('The file "%s" should be readable', $this->_filename)
        );

        $this->beConstructedWith($this->_filename);
        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_should_open_file_as_stream()
    {
        $this->open()->shouldBeResource();
    }

    function generateFile($ext, $readable = true)
    {
        $filename = sys_get_temp_dir().'/test_'.time().$ext;
        file_put_contents($filename, '');

        if (!$readable) {
            chmod($filename, 0200);
        }

        $this->_filename = $filename;
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Attachment::TYPE_IMAGE,
            'payload' => [],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
