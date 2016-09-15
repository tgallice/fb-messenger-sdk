<?php

namespace spec\Tgallice\FBMessenger\Model;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Model\Attachment;
use Tgallice\FBMessenger\Model\Attachment\File;
use Tgallice\FBMessenger\Model\Message;
use Tgallice\FBMessenger\Model\QuickReply;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('message');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Model\Message');
    }

    function it_can_be_constructed_with_an_attachment(Attachment $attachment)
    {
        $this->beConstructedWith($attachment);
        $expected = [
            Message::TYPE_ATTACHMENT => $attachment,
            'quick_replies' => null,
            'metadata' => null,
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }

    function it_throws_exception_if_constructed_with_an_invalid_data_value()
    {
        $this->beConstructedWith(1);
        $exception = new \InvalidArgumentException('Invalid $data. It must be a string or an Attachment');
        $this->shouldThrow($exception)->duringInstantiation();
    }

    function it_has_a_data()
    {
        $this->getData()->shouldReturn('message');
        $this->hasFileToUpload()->shouldReturn(false);
    }

    function it_has_no_default_quick_replies()
    {
        $this->getQuickReplies()->shouldReturn(null);
    }

    function it_can_set_quick_replies(QuickReply $quickReply)
    {
        $this->setQuickReplies([$quickReply]);
        $this->getQuickReplies()->shouldReturn([$quickReply]);
    }

    function it_can_add_quick_reply(QuickReply $quickReply)
    {
        $this->setQuickReplies([$quickReply]);
        $this->addQuickReply($quickReply);

        $this->getQuickReplies()->shouldReturn([$quickReply, $quickReply]);
    }

    function it_throw_an_exception_if_quick_replies_limit_exceeded(QuickReply $quickReply)
    {
        $quickReplies = array_fill(0, 11, $quickReply);

        $this->shouldThrow(new \InvalidArgumentException('A message can not have more than 10 quick replies.'))
            ->duringSetQuickReplies($quickReplies);
    }

    function it_throw_an_exception_if_add_quick_reply_and_exceeded_the_limit(QuickReply $quickReply)
    {
        $quickReplies = array_fill(0, 10, $quickReply);
        $this->setQuickReplies($quickReplies);

        $this->shouldThrow(new \InvalidArgumentException('A message can not have more than 10 quick replies.'))
            ->duringAddQuickReply($quickReply);
    }

    function it_has_no_default_metadata()
    {
        $this->getMetadata()->shouldReturn(null);
    }

    function it_can_define_metadata()
    {
        $this->setMetadata('metadata');
        $this->getMetadata()->shouldReturn('metadata');
    }

    function it_throws_exception_if_text_metadata_exceed_1000_characters()
    {
        $exception = new \InvalidArgumentException('$metadata should not exceed 1000 characters.');
        $this->shouldThrow($exception)->duringSetMetadata(str_repeat('text', 1001));
    }

    function it_can_check_if_message_contain_file_to_upload(File $file)
    {
        $file->isRemoteFile()->willReturn(false);

        $this->beConstructedWith($file);
        $this->hasFileToUpload()->shouldReturn(true);
    }

    function it_can_get_the_file_stream(File $file)
    {
        $file->getStream()->willReturn('stream');

        $this->beConstructedWith($file);
        $this->getFileStream()->shouldReturn('stream');
    }

    function it_must_be_json_serializable(QuickReply $quickReply)
    {
        $this->shouldImplement(\JsonSerializable::class);

        $this->addQuickReply($quickReply);
        $this->setmetadata('metadata');

        $expected = [
            Message::TYPE_TEXT => 'message',
            'quick_replies' => [$quickReply],
            'metadata' => 'metadata',
        ];

        $this->jsonSerialize()->shouldBeLike($expected);
    }
}
