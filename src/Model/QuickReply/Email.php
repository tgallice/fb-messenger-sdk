<?php

namespace Tgallice\FBMessenger\Model\QuickReply;

use Tgallice\FBMessenger\Model\QuickReply;

class Email extends QuickReply
{
    public function __construct()
    {
        parent::__construct(QuickReply::TYPE_USER_EMAIL);
    }
}