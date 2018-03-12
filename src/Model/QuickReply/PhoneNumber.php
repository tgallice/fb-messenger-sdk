<?php

namespace Tgallice\FBMessenger\Model\QuickReply;

use Tgallice\FBMessenger\Model\QuickReply;

class PhoneNumber extends QuickReply
{
    public function __construct()
    {
        parent::__construct(QuickReply::TYPE_USER_PHONE_NUMBER);
    }
}