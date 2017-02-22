<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Message
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $sequence;

    /**
     * @var null|string
     */
    private $text;

    /**
     * @var array
     */
    private $attachments;

    /**
     * @var null|string
     */
    private $quickReply;

    /**
     * @param string $id
     * @param int $sequence
     * @param null|string $text
     * @param array $attachments
     * @param null|string $quickReply
     */
    public function __construct($id, $sequence, $text = null, array $attachments = [], $quickReply = null)
    {
        $this->id = $id;
        $this->sequence = $sequence;
        $this->text = $text;
        $this->attachments = $attachments;
        $this->quickReply = $quickReply;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return null|string
     */
    public function getQuickReply()
    {
        return $this->quickReply;
    }

    /**
     * @return bool
     */
    public function hasText()
    {
        return !empty($this->text);
    }

    /**
     * @return bool
     */
    public function hasAttachments()
    {
        return !empty($this->attachments);
    }

    /**
     * @return bool
     */
    public function hasQuickReply()
    {
        return !empty($this->quickReply);
    }

    /**
     * @return bool
     */
    public function hasLocation()
    {
        return $this->hasAttachments() && $this->attachments[0]['type'] === 'location';
    }

    /**
     * @return string|null
     */
    public function getLatitude()
    {
    	return $this->hasLocation() ? $this->attachments[0]['payload']['coordinates']['lat'] : null;
    }
    
    /**
     * @return string|null
     */
    public function getLongitude()
    {
    	return $this->hasLocation() ? $this->attachments[0]['payload']['coordinates']['long'] : null;
    }
    
    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $text = isset($payload['text']) ? $payload['text'] : null;
        $attachments = isset($payload['attachments']) ? $payload['attachments'] : [];
        $quickReply = isset($payload['quick_reply']) ? $payload['quick_reply']['payload'] : null;

        return new static($payload['mid'], $payload['seq'], $text, $attachments, $quickReply);
    }
}
