<?php

namespace Tgallice\FBMessenger\Model\QuickReply;

use Tgallice\FBMessenger\Model\QuickReply;

class Location extends QuickReply
{
    public function __construct()
    {
        parent::__construct(QuickReply::TYPE_LOCATION);
    }
}