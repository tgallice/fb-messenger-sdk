<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\Callback\MessageEvent;
use Tgallice\FBMessenger\Model\Callback\Entry;
use Tgallice\FBMessenger\XHubSignature;

class WebhookRequestHandlerSpec extends ObjectBehavior
{
    function let(ServerRequestInterface $request, StreamInterface $stream, EventDispatcherInterface $dispatcher)
    {
        $payload = '
        {
          "object": "page",
          "entry": [
            {
              "id": "PAGE_ID",
              "time": 1473204787206,
              "messaging": [
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
                    "text":"hello, world!",
                    "quick_reply": {
                      "payload": "DEVELOPER_DEFINED_PAYLOAD"
                    }
                  }
                }   
              ]
            }
          ]
        } 
        ';

        $stream->__toString()->willReturn($payload);

        $signature = XHubSignature::compute($payload, 'secret');

        $request->getBody()->willReturn($stream);
        $request->getHeader('X-Hub-Signature')->willReturn(['sha1='.$signature]);

        $this->beConstructedWith('secret', 'verify_token', $dispatcher);
        $this->handleRequest($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\WebhookRequestHandler');
    }

    function it_has_a_request($request)
    {
        $this->getRequest()->shouldReturn($request);
    }

    function it_has_all_events()
    {
        $events = $this->getAllCallbackEvents();
        $events[0]->shouldBeAnInstanceOf(CallbackEvent::class);
    }

    function it_has_an_entries()
    {
        $entries = $this->getEntries();
        $entries[0]->shouldBeAnInstanceOf(Entry::class);
    }

    function it_check_if_its_a_valid_callback_request()
    {
        $this->isValidCallbackRequest()->shouldReturn(true);
    }

    function it_check_if_it_is_an_invalid_callback_request($request)
    {
        $request->getHeader('X-Hub-Signature')->willReturn(['sha1=bad']);

        $this->isValidCallbackRequest()->shouldReturn(false);
    }

    function it_check_if_its_a_malformed_callback_request($stream)
    {
        $stream->__toString()->willReturn('{}');

        $this->isValidCallbackRequest()->shouldReturn(false);
    }

    function it_has_a_decoded_body($stream)
    {
        $stream->__toString()->willReturn('{"test": "value"}');

        $this->getDecodedBody()->shouldReturn(['test' => 'value']);
    }

    function it_check_if_it_is_a_valid_verify_token_request($request)
    {
        $request->getMethod()->willReturn('GET');
        $request->getQueryParams()->willReturn([
            'hub_verify_token' => 'verify_token',
        ]);
        $this->isValidVerifyTokenRequest()->shouldReturn(true);
    }

    function it_has_a_challenge($request)
    {
        $request->getQueryParams()->willReturn([
            'hub_challenge' => 'challenge',
        ]);

        $this->getChallenge()->shouldReturn('challenge');
    }

    function it_dispatch_events($dispatcher)
    {
        $dispatcher->dispatch(MessageEvent::NAME, Argument::type(MessageEvent::class))->shouldBeCalled();
        $dispatcher->dispatch('DEVELOPER_DEFINED_PAYLOAD', Argument::type(MessageEvent::class))->shouldBeCalled();
        $this->dispatchCallbackEvents();
    }

    function it_add_event_subscriber($dispatcher, EventSubscriberInterface $subscriber)
    {
        $dispatcher->addSubscriber($subscriber)->shouldBeCalled();
        $this->addEventSubscriber($subscriber);
    }
}
