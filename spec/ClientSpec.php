<?php

namespace spec\Tgallice\FBMessenger;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Tgallice\FBMessenger\Exception\ApiException;

class ClientSpec extends ObjectBehavior
{
    function let(ClientInterface $httpClient, ResponseInterface $response)
    {
        $response->getStatusCode()->willReturn(200);
        $this->beConstructedWith('token', $httpClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Client');
    }

    function it_has_shortcut_post_request($httpClient, $response)
    {
        $httpClient->request('POST', '/uri', Argument::withEntry('body', 'value'))->willReturn($response);
        $this->post('/uri', 'value')->shouldReturn($response);
    }

    function it_has_shortcut_get_request($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('query', ['q' => 'text', 'access_token' => 'token']))->willReturn($response);
        $this->get('/uri', ['q' => 'text'])->shouldReturn($response);
    }

    function it_has_shortcut_put_request($httpClient, $response)
    {
        $httpClient->request('PUT', '/uri', Argument::withEntry('body', ['obj' => 'value']))->willReturn($response);
        $this->put('/uri', ['obj' => 'value'])->shouldReturn($response);
    }

    function it_has_shortcut_delete_request($httpClient, $response)
    {
        $httpClient->request('DELETE', '/uri', Argument::withEntry('options', 'value'))->willReturn($response);
        $this->delete('/uri', ['options' => 'value'])->shouldReturn($response);
    }

    function it_should_send_request($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::any())->willReturn($response);
        $this->send('GET', '/uri')->shouldReturn($response);
    }

    function it_should_send_request_with_custom_headers($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('headers', ['foo' => 'bar', 'Content-Type' => 'application/json']))->willReturn($response);
        $this->send('GET', '/uri', null, [], ['foo' => 'bar'])->shouldReturn($response);
    }

    function it_should_send_request_with_custom_query($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('query', ['foo' => 'bar', 'access_token' => 'token']))->willReturn($response);
        $this->send('GET', '/uri', null, ['foo' => 'bar'])->shouldReturn($response);
    }

    function it_should_send_request_with_custom_body($httpClient, $response)
    {
        $httpClient->request('POST', '/uri', Argument::withEntry('body', 'foo'))->willReturn($response);
        $this->send('POST', '/uri', 'foo')->shouldReturn($response);
    }

    function it_should_send_request_with_custom_options($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('timeout', 10))->willReturn($response);
        $this->send('GET', '/uri', null, [], [], ['timeout' => 10])->shouldReturn($response);
    }

    function it_should_get_the_last_api_response($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::any())->willReturn($response);
        $this->send('GET', '/uri');
        $this->getLastResponse()->shouldReturn($response);
    }

    function it_should_have_a_default_http_client()
    {
        $this->beConstructedWith('token');
        $this->getHttpClient()->shouldReturnAnInstanceOf(ClientInterface::class);
    }

    function it_validate_response_or_trigger_an_exception($httpClient, $response)
    {
        $response->getStatusCode()->willReturn(400);
        $response->getReasonPhrase()->willReturn('error message');
        $response->getBody()->willReturn('{
            "data": "value"
        }');
        $httpClient->request('GET', '/uri', Argument::any())->willReturn($response);
        $this->shouldThrow(new ApiException('error message', ["data" => "value"]))->duringSend('GET', '/uri');
    }
}
