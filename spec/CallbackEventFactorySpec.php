<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;
use Tgallice\FBMessenger\Callback\AccountLinkingEvent;
use Tgallice\FBMessenger\Callback\AuthenticationEvent;
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

class CallbackEventFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\CallbackEventFactory');
    }

    function it_create_a_message_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "timestamp":1458692752478,
              "message":{
                "mid":"mid.1457764197618:41d102a3e1ae206a38",
                "seq":73,
                "attachments": [{"type": "image", "url": "http://domain.com/example.jpg"}],
                "text":"hello, world!",
                "quick_reply": {
                  "payload": "DEVELOPER_DEFINED_PAYLOAD"
                }
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, Message::create($arr['message']));

        $event = $this::createMessageEvent($arr);
        $event->shouldBeLike($expectedEvent);
        $event->getMessage()->getAttachments()->shouldBeLike([[
            "type" => "image",
            "url" => "http://domain.com/example.jpg"
        ]]);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_a_postback_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "timestamp":1458692752478,
              "postback":{
                "payload":"USER_DEFINED_PAYLOAD"
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new PostbackEvent('USER_ID', 'PAGE_ID', 1458692752478, Postback::create($arr['postback']));

        $event = $this::createPostbackEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_an_authentication_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "timestamp":1234567890,
              "optin":{
                "ref":"PASS_THROUGH_PARAM"
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new AuthenticationEvent('USER_ID', 'PAGE_ID', 1234567890, Optin::create($arr['optin']));

        $event = $this::createAuthenticationEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_an_account_linking_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "timestamp":1234567890,
              "account_linking":{
                "status":"linked",
                "authorization_code":"PASS_THROUGH_AUTHORIZATION_CODE"
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new AccountLinkingEvent('USER_ID', 'PAGE_ID', 1234567890, AccountLinking::create($arr['account_linking']));

        $event = $this::createAccountLinkingEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_a_message_delivery_event()
    {
        $raw = '
            {
               "sender":{
                  "id":"USER_ID"
               },
               "recipient":{
                  "id":"PAGE_ID"
               },
               "delivery":{
                  "mids":[
                     "mid.1458668856218:ed81099e15d3f4f233"
                  ],
                  "watermark":1458668856253,
                  "seq":37
               }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new MessageDeliveryEvent('USER_ID', 'PAGE_ID', Delivery::create($arr['delivery']));

        $event = $this::createMessageDeliveryEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_a_message_read_event()
    {
        $raw = '
            {
               "sender":{
                  "id":"USER_ID"
               },
               "recipient":{
                  "id":"PAGE_ID"
               },
               "timestamp":1458668856463,
               "read":{
                  "watermark":1458668856253,
                  "seq":38
               }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new MessageReadEvent('USER_ID', 'PAGE_ID', 1458668856463, Read::create($arr['read']));

        $event = $this::createMessageReadEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_a_message_echo_event()
    {
        $raw = '
            {
              "sender":{
                "id":"PAGE_ID"
              },
              "recipient":{
                "id":"USER_ID"
              },
              "timestamp":1457764197627,
              "message":{
                "is_echo":true,
                "app_id":1517776481860111,
                "metadata": "DEVELOPER_DEFINED_METADATA_STRING",
                "mid":"mid.1457764197618:41d102a3e1ae206a38",
                "seq":73
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new MessageEchoEvent('PAGE_ID', 'USER_ID', 1457764197627, MessageEcho::create($arr['message']));

        $event = $this::createMessageEchoEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }

    function it_create_a_raw_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "unknown":{
                "item":"value"
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new RawEvent('USER_ID', 'PAGE_ID', $arr);

        $event = $this::create($arr);
        $event->shouldBeLike($expectedEvent);
    }

    function it_create_a_referral_event()
    {
        $raw = '
            {
              "sender":{
                "id":"USER_ID"
              },
              "recipient":{
                "id":"PAGE_ID"
              },
              "timestamp":1458692752478,
              "referral": {
                "ref": "value",
                "source": "SHORTLINK",
                "type": "OPEN_THREAD"
              }
            }
        ';

        $arr = json_decode($raw, true);

        $expectedEvent = new ReferralEvent('USER_ID', 'PAGE_ID', 1458692752478, Referral::create($arr['referral']));

        $event = $this::createReferralEvent($arr);
        $event->shouldBeLike($expectedEvent);

        $event2 = $this::create($arr);
        $event2->shouldBeLike($expectedEvent);
    }
}
