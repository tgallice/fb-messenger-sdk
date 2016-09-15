<?php

namespace Tgallice\FBMessenger\Model\Attachment;


use Tgallice\FBMessenger\Model\Attachment;

abstract class Template implements \JsonSerializable
{
    const TYPE_GENERIC = 'generic';
    const TYPE_BUTTON = 'button';
    const TYPE_RECEIPT = 'receipt';

    abstract public function getType();
}
