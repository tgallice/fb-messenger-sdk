<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;

abstract class Template extends Attachment
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Attachment::TYPE_TEMPLATE;
    }
}
