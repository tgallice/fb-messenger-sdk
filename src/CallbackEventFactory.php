<?php

namespace Tgallice\FBMessenger;

use Tgallice\FBMessenger\Callback\AccountLinkingEvent;
use Tgallice\FBMessenger\Callback\AuthenticationEvent;
use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\Callback\MessageDeliveryEvent;
use Tgallice\FBMessenger\Callback\MessageEchoEvent;
use Tgallice\FBMessenger\Callback\MessageEvent;
use Tgallice\FBMessenger\Callback\MessageReadEvent;
use Tgallice\FBMessenger\Callback\PostbackEvent;
use Tgallice\FBMessenger\Callback\ReferralEvent;
use Tgallice\FBMessenger\Callback\RawEvent;
use Tgallice\FBMessenger\Model\Callback\AccountLinking;
use Tgallice\FBMessenger\Model\Callback\Delivery;
use Tgallice\FBMessenger\Model\Callback\Message;
use Tgallice\FBMessenger\Model\Callback\MessageEcho;
use Tgallice\FBMessenger\Model\Callback\Optin;
use Tgallice\FBMessenger\Model\Callback\Postback;
use Tgallice\FBMessenger\Model\Callback\Read;
use Tgallice\FBMessenger\Model\Callback\Referral;

class CallbackEventFactory
{
    /**
     * @param array $payload
     *
     * @return CallbackEvent
     */
    public static function create(array $payload)
    {
        // MessageEvent & MessageEchoEvent
        if (isset($payload['message'])) {
            if (isset($payload['message']['is_echo'])) {
                return self::createMessageEchoEvent($payload);
            }

            return self::createMessageEvent($payload);
        }
        
        // PostbackEvent
        if (isset($payload['postback'])) {
            return self::createPostbackEvent($payload);
        }

        // AuthenticationEvent
        if (isset($payload['optin'])) {
            return self::createAuthenticationEvent($payload);
        }

        // AccountLinkingEvent
        if (isset($payload['account_linking'])) {
            return self::createAccountLinkingEvent($payload);
        }

        // MessageDeliveryEvent
        if (isset($payload['delivery'])) {
            return self::createMessageDeliveryEvent($payload);
        }

        // MessageReadEvent
        if (isset($payload['read'])) {
            return self::createMessageReadEvent($payload);
        }

        // ReferralEvent
        if(isset($payload['referral'])) {
            return self::createReferralEvent($payload);
        }

        return new RawEvent($payload['sender']['id'], $payload['recipient']['id'], $payload);
    }

    /**
     * @param array $payload
     *
     * @return MessageEvent
     */
    public static function createMessageEvent(array $payload)
    {
        $message = Message::create($payload['message']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new MessageEvent($senderId, $recipientId, $timestamp, $message);
    }

    /**
     * @param array $payload
     *
     * @return MessageEchoEvent
     */
    public static function createMessageEchoEvent(array $payload)
    {
        $message = MessageEcho::create($payload['message']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new MessageEchoEvent($senderId, $recipientId, $timestamp, $message);
    }

    /**
     * @param array $payload
     *
     * @return PostbackEvent
     */
    public static function createPostbackEvent(array $payload)
    {
        $postback = Postback::create($payload['postback']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new PostbackEvent($senderId, $recipientId, $timestamp, $postback);
    }

    /**
     * @param array $payload
     *
     * @return AuthenticationEvent
     */
    public static function createAuthenticationEvent(array $payload)
    {
        $optin = Optin::create($payload['optin']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new AuthenticationEvent($senderId, $recipientId, $timestamp, $optin);
    }

    /**
     * @param array $payload
     *
     * @return AccountLinkingEvent
     */
    public static function createAccountLinkingEvent(array $payload)
    {
        $accountLinking = AccountLinking::create($payload['account_linking']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new AccountLinkingEvent($senderId, $recipientId, $timestamp, $accountLinking);
    }

    /**
     * @param array $payload
     *
     * @return MessageDeliveryEvent
     */
    public static function createMessageDeliveryEvent(array $payload)
    {
        $delivery = Delivery::create($payload['delivery']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];

        return new MessageDeliveryEvent($senderId, $recipientId, $delivery);
    }

    /**
     * @param array $payload
     * 
     * @return MessageReadEvent
     */
    public static function createMessageReadEvent(array $payload)
    {
        $read = Read::create($payload['read']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new MessageReadEvent($senderId, $recipientId, $timestamp, $read);
    }

    /**
     * @param array $payload
     *
     * @return ReferralEvent
     */
    public static function createReferralEvent(array $payload)
    {
        $referral = Referral::create($payload['referral']);
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        return new ReferralEvent($senderId, $recipientId, $timestamp, $referral);
    }
}
