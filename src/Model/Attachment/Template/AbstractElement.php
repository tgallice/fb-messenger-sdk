<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template;

abstract class AbstractElement implements \JsonSerializable
{
    /**
     * @var string
     */
    private $title;
    
    /**
     * @var null|string
     */
    private $subtitle;

    /**
     * @var null|string
     */
    private $imageUrl;

    /**
     * @param string $title
     * @param null|string $subtitle
     * @param null|string $imageUrl
     */
    public function __construct($title, $subtitle = null, $imageUrl = null)
    {
        if (mb_strlen($title) > 80) {
            throw new \InvalidArgumentException('In a element, the "title" field should not exceed 80 characters.');
        }

        if (!empty($subtitle) && mb_strlen($subtitle) > 80) {
            throw new \InvalidArgumentException('In a element, the "subtitle" field should not exceed 80 characters.');
        }
        
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->imageUrl = $imageUrl;
    }
    
    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return null|string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @deprecated use the constructor argument instead
     * @param null|string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }


    /**
     * @deprecated use the constructor argument instead
     * @param null|string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        if (!empty($subtitle) && mb_strlen($subtitle) > 80) {
            throw new \InvalidArgumentException('In a element, the "subtitle" field should not exceed 80 characters.');
        }

        $this->subtitle = $subtitle;
    }
}
