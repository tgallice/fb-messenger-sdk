<?php

namespace spec\Tgallice\FBMessenger;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
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

    function it_convert_array_body_as_json_content($httpClient, $response)
    {
        $body = ['value' => 'test'];

        $httpClient->request('POST', '/uri', Argument::that(function ($options) use ($body) {
            return $options['body'] === json_encode($body) && $options['headers']['Content-Type'] === 'application/json';
        }))->willReturn($response);

        $this->post('/uri', $body)->shouldReturn($response);

        $this->send('POST', '/uri', $body)->shouldReturn($response);
    }

    function it_has_shortcut_get_request($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('query', ['q' => 'text', 'access_token' => 'token']))->willReturn($response);
        $this->get('/uri', ['q' => 'text'])->shouldReturn($response);
    }

    function it_has_shortcut_put_request($httpClient, $response)
    {
        $httpClient->request('PUT', '/uri', Argument::withEntry('body', json_encode(['obj' => 'value'])))->willReturn($response);
        $this->put('/uri', ['obj' => 'value'])->shouldReturn($response);
    }

    function it_has_shortcut_delete_request($httpClient, $response)
    {
        $httpClient->request('DELETE', '/uri', Argument::withEntry('query', ['access_token' => 'token']))->willReturn($response);
        $this->delete('/uri')->shouldReturn($response);
    }

    function it_should_send_request($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::any())->willReturn($response);
        $this->send('GET', '/uri')->shouldReturn($response);
    }

    function it_should_send_request_with_custom_headers($httpClient, $response)
    {
        $httpClient->request('GET', '/uri', Argument::withEntry('headers', ['foo' => 'bar']))->willReturn($response);
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

    function it_throw_exception_if_error_is_return_from_api($httpClient, ResponseInterface $response)
    {
        $error = '{
            "error": {
                "message":"Invalid parameter",
                "type":"FacebookApiException",
                "code":100,
                "error_data":"No matching user found.",
                "fbtrace_id":"D2kxCybrKVw"
            }
        }';
        $response->getBody()->willReturn($error);
        
        $response->getStatusCode()->willReturn(400);
        $response->getReasonPhrase()->willReturn('');

        $httpClient->request('POST', '/uri', Argument::any())->willReturn($response);

        $errorDecoded = json_decode($error, true);

        $this->shouldThrow(new ApiException('Invalid parameter', 100, $errorDecoded))->duringSend('POST', '/uri');
    }

    function it_catch_exception_from_client_($httpClient)
    {
        $exception = new TransferException('Exception client');
        $httpClient->request('POST', '/uri', Argument::any())->willThrow($exception);

        $this->shouldThrow(new ApiException($exception->getMessage(),
            $exception->getCode()
        ))->duringSend('POST', '/uri');
    }
}
