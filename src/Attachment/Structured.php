<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;

abstract class Structured extends Attachment
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Attachment::TYPE_TEMPLATE;
    }
}
