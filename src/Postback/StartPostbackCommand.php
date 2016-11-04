<?php

namespace Tgallice\FBMessenger\Postback;

/**
 * Class StartPostbackCommand
 * @package Tgallice\FBMessenger\Postback
 */
class StartPostbackCommand extends PostbackCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->replyWithMessage('Welcome!');
    }
}
