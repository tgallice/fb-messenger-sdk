<?php

namespace Tgallice\FBMessenger\Postback;

use Tgallice\FBMessenger;
use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\NotificationType;
use Tgallice\FBMessenger\Callback\PostbackEvent;
use Tgallice\FBMessenger\Model\Callback\Postback;

/**
 * Class PostbackCommand
 * @package Tgallice\FBMessenger\Postback
 */
abstract class PostbackCommand
{

    /**
     * @var Messenger
     */
    protected $messenger;

    /**
     * @var PostbackEvent
     */
    protected $event;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return Postback
     */
    public function getPostback()
    {
        return $this->event->getPostback();
    }

    /**
     * @return Messenger
     */
    public function getMessenger()
    {
        return $this->messenger;
    }

    /**
     * @return PostbackEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param $message
     * @param string $notificationType
     */
    public function replyWithMessage($message, $notificationType = NotificationType::REGULAR)
    {
        $this->messenger->sendMessage($this->event->getSenderId(), $message, $notificationType);
    }

    /**
     * @param $messenger
     * @param $event
     * @return mixed
     */
    public function initialize($messenger, $event)
    {
        $this->messenger = $messenger;
        $this->event = $event;

        return $this->run();
    }

    /**
     * @return mixed
     */
    abstract public function run();
}