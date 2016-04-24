<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Template;

class Structured extends Attachment
{
    /**
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->payload = $template;
        $this->type = Attachment::TYPE_TEMPLATE;
    }
}
