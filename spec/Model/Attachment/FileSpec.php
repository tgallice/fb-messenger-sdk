<?php

namespace spec\Tgallice\FBMessenger\Model\Attachment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Tgallice\FBMessenger\Model\Attachment;

class FileSpec extends ObjectBehavior
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
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Attachment\File');
    }

    function it_is_a_attachment()
    {
        $this->shouldImplement('Tgallice\FBMessenger\Model\Attachment');
    }

    function it_has_a_file_type()
    {
        $this->getType()->shouldReturn(Attachment::TYPE_FILE);
    }

    function it_has_a_path()
    {
        $this->getPath()->shouldReturn($this->_filename);
    }

    function it_can_check_if_its_a_remote_file()
    {
        $this->isRemoteFile()->shouldReturn(false);
    }

    function it_allow_remote_file()
    {
        $this->beConstructedWith('http://www.file.com/file.png');
        $this->getPayload()->shouldReturn([
            'url' => 'http://www.file.com/file.png',
        ]);
        $this->isRemoteFile()->shouldReturn(true);
    }

    function it_should_not_open_remote_file()
    {
        $this->beConstructedWith('http://www.file.com/file.png');
        $this->shouldThrow(new \RuntimeException('A remote file can not be open'))
            ->duringOpen();
    }

    function it_throws_exception_when_the_local_file_is_not_readable()
    {
        $this->generateFile('.jpg', false);

        $exception = new \InvalidArgumentException(
            sprintf('The file "%s" should be readable', $this->_filename)
        );

        $this->beConstructedWith($this->_filename);
        $this->shouldThrow($exception)->duringOpen();
    }

    function it_should_open_file_as_stream()
    {
        $this->open();
        $this->getStream()->shouldBeResource();
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
}
