<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\Model\Callback\Entry;
use Tgallice\FBMessenger\XHubSignature;

class WebhookRequestHandlerSpec extends ObjectBehavior
{
    function let(RequestInterface $request, StreamInterface $stream)
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

        $stream->rewind()->willReturn(true);
        $stream->getContents()->willReturn($payload);

        $signature = XHubSignature::compute($payload, 'secret');

        $request->getBody()->willReturn($stream);
        $request->getHeader('X-Hub-Signature')->willReturn(['sha1='.$signature]);

        $this->beConstructedWith('secret', $request);
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
        $this->isValid()->shouldReturn(true);
    }

    function it_check_if_its_an_invalid_callback_request($request)
    {
        $request->getHeader('X-Hub-Signature')->willReturn(['sha1=bad']);

        $this->isValid()->shouldReturn(false);
    }

    function it_check_if_its_a_malformed_callback_request($stream)
    {
        $stream->getContents()->willReturn('{}');

        $this->isValid()->shouldReturn(false);
    }

    function it_has_a_decoded_body($stream)
    {
        $stream->getContents()->willReturn('{"test": "value"}');

        $this->getDecodedBody()->shouldReturn(['test' => 'value']);
    }
}
