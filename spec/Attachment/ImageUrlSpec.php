<?php

namespace spec\Tgallice\FBMessenger\Attachment;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Attachment;

class ImageUrlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://www.file.com/file.png');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Attachment\ImageUrl');
    }

    function it_is_a_attachment()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Attachment');
    }

    function it_should_return_the_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_IMAGE);
    }

    function it_should_return_the_file_url()
    {
        $this->getUrl()->shouldReturn('http://www.file.com/file.png');
    }

    function it_should_return_a_payload()
    {
        $this->getPayload()->shouldReturn([
            'url' => 'http://www.file.com/file.png',
        ]);
    }

    function it_throws_exception_when_the_file_is_not_a_png_or_a_jpg()
    {
        $this->beConstructedWith('http://file.com/file.ext');
        $exception = new \InvalidArgumentException(
            sprintf(
                '"%s" this file has not a allowed extension. Only "png" and "jpg" image are supported',
                'http://file.com/file.ext'
            )
        );

        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_throws_exception_when_the_file_is_not_a_remote_file()
    {
        $this->beConstructedWith('./file.png');
        $exception = new \InvalidArgumentException(sprintf('"%s" is not a valid remote file', './file.png'));

        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_should_be_serializable()
    {
        $this->shouldImplement(\JsonSerializable::class);

        $expected = [
            'type' => Attachment::TYPE_IMAGE,
            'payload' => [
                'url' => 'http://www.file.com/file.png',
            ],
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
