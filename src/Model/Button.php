<?php

namespace Tgallice\FBMessenger\Model;

abstract class Button implements \JsonSerializable
{
    const TYPE_POSTBACK = 'postback';

    const TYPE_WEB_URL = 'web_url';

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @throws \InvalidArgumentException
     */
    protected function validateTitleSize($title)
    {
        if (mb_strlen($title) > 20) {
            throw new \InvalidArgumentException('A call to action title field should not exceed 20 characters');
        }
    }
}
