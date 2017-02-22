<?php

namespace Tgallice\FBMessenger\Model\QuickReply;

use Tgallice\FBMessenger\Model\QuickReply;

class Text extends QuickReply
{
    /**
     * @var string
     */
    private $title;

    /**
     * Payload
     *
     * @var string
     */
    private $payload;
    
    /**
     * @var string
     */
    private $image_url;
    
    /**
     * @param string $title
     * @param string $payload
     */
    public function __construct($title, $payload, $image_url = null)
    {
        parent::__construct(QuickReply::TYPE_TEXT);
    
        self::validateTitleSize($title);
        $this->title = $title;
    
        QuickReply::validatePayload($payload);
        $this->payload = $payload;
        
        $this->image_url = $image_url;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }
    
    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }
    
    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['title'] = $this->title;
        $json['payload'] = $this->payload;
    
        if(!empty($this->image_url)) {
            $json['image_url'] = $this->image_url;
        }
        
        return $json;
    }
}
