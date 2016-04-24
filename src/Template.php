<?php

namespace Tgallice\FBMessenger;

abstract class Template implements \JsonSerializable
{
    const TYPE_BUTTON = 'button';

    const TYPE_GENERIC = 'generic';

    const TYPE_RECEIPT = 'receipt';

    /**
     * @var string
     */
    abstract public function getType();
}
