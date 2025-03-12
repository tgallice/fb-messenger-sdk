<?php

namespace Tgallice\FBMessenger\Model;

use Tgallice\FBMessenger\Model\Attachment\File;

class Message implements \JsonSerializable
{
    const TYPE_TEXT = 'text';

    const TYPE_ATTACHMENT = 'attachment';

    /**
     * @var string|Attachment
     */
    private $type;

    /**
     * @var string|Attachment
     */
    private $data;

    /**
     * @var null|QuickReply[]
     */
    private $quickReplies;

    /**
     * @var null|string
     */
    private $metadata;

    /**
     * @param string|Attachment $data
     */
    public function __construct($data)
    {
        if (is_string($data)) {
            $this->type = self::TYPE_TEXT;
        } elseif ($data instanceOf Attachment) {
            $this->type = self::TYPE_ATTACHMENT;
        } else {
            throw new \InvalidArgumentException('Invalid $data. It must be a string or an Attachment');
        }

        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string|Attachment
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return null|QuickReply[]
     */
    public function getQuickReplies()
    {
        return $this->quickReplies;
    }

    /**
     * @return null|string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param null|QuickReply[] $quickReplies
     */
    public function setQuickReplies(?array $quickReplies = null)
    {
        if (count($quickReplies) > 10) {
            throw new \InvalidArgumentException('A message can not have more than 10 quick replies.');
        }

        $this->quickReplies = empty($quickReplies) ? null : $quickReplies;
    }

    /**
     * @param QuickReply $quickReply
     */
    public function addQuickReply(QuickReply $quickReply)
    {
        if (count($this->quickReplies) >= 10) {
            throw new \InvalidArgumentException('A message can not have more than 10 quick replies.');
        }

        if (!is_array($this->quickReplies)) {
            $this->quickReplies = [];
        }

        $this->quickReplies[] = $quickReply;
    }

    /**
     * @param null|string $metadata
     */
    public function setMetadata($metadata = null)
    {
        if ($metadata !== null && mb_strlen($metadata) > 1000) {
            throw new \InvalidArgumentException('$metadata should not exceed 1000 characters.');
        }

        $this->metadata = empty($metadata) ? null : $metadata;
    }

    /**
     * Check if the message contains file
     *
     * @return bool
     */
    public function hasFileToUpload()
    {
        if (!$this->data instanceof File) {
            return false;
        }

        return !$this->data->isRemoteFile();
    }

    /**
     * Return a stream of the local file attachment
     *
     * @return resource|null
     */
    public function getFileStream()
    {
        if (!$this->data instanceof File) {
            return null;
        }

        return $this->data->getStream();
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            $this->type => $this->data,
            'quick_replies' => $this->quickReplies,
            'metadata' => $this->metadata,
        ];
    }
}
