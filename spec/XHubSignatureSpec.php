<?php

namespace spec\Tgallice\FBMessenger;

use PhpSpec\ObjectBehavior;

class XHubSignatureSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\XHubSignature');
    }

    function it_validate_payload()
    {
        $payload = 'payload';
        $secret = 'secret';
        $signature = hash_hmac('sha1', $payload, $secret);
        $this::validate($payload, $secret, $signature)->shouldReturn(true);
        $this::validate('badpayload', $secret, $signature)->shouldReturn(false);
    }

    function it_compute_payload_with_secret()
    {
        $payload = 'payload';
        $secret = 'secret';
        $signature = hash_hmac('sha1', $payload, $secret);
        $this::compute($payload, $secret)->shouldReturn($signature);
    }

    function it_parse_x_hub_signature_header()
    {
        $header= "sha1=123456";

        $this::parseHeader($header)->shouldReturn('123456');
    }
}
