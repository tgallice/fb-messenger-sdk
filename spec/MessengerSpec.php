<?php

namespace spec\Tgallice\FBMessenger;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\RequestOptions;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\Attachment\Template;
use Tgallice\FBMessenger\Exception\ApiException;
use Tgallice\FBMessenger\Message\Message;
use Tgallice\FBMessenger\Model\MessageResponse;
use Tgallice\FBMessenger\Model\UserProfile;

class MessengerSpec extends ObjectBehavior
{
    function let(ClientInterface $client)
    {
        $this->beConstructedWith('token', $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tgallice\FBMessenger\Messenger');
    }

    function it_get_user_profile($client, ResponseInterface $response)
    {
        $response->getBody()->willReturn('
            {
                "first_name": "Peter",
                "last_name": "Chang",
                "profile_pic": "https://fbcdn-profile-a.akamaihd.net/hprofile70ec9c19b18"
            }
        ');

        $client->request('GET', '/user_id', [
            RequestOptions::QUERY => [
                'fields' => 'first_name,last_name,profile_pic',
                'access_token' => 'token'
            ],
        ])->willReturn($response);

        $userProfile = new UserProfile('Peter', 'Chang', "https://fbcdn-profile-a.akamaihd.net/hprofile70ec9c19b18");

        $this->getUserProfile('user_id', ['first_name', 'last_name', 'profile_pic'])
            ->shouldBeLike($userProfile);
    }

    function it_send_message_to_user($client, Message $message, ResponseInterface $response)
    {
        $message->hasFileToUpload()->willReturn(false);
        $message->format()->willReturn([
            'data' => 'value',
        ]);

        $client->request('POST', '/me/messages', [
            RequestOptions::JSON => ['data' => 'value'],
            RequestOptions::QUERY => ['access_token' => 'token'],
        ])->willReturn($response);

        $response->getBody()->willReturn('
            {
                "recipient_id": "1008372609250235",
                "message_id": "mid.1456970487936:c34767dfe57ee6e339"
            }
        ');

        $this->sendMessage($message)->shouldBeLike(
            new MessageResponse('1008372609250235', 'mid.1456970487936:c34767dfe57ee6e339')
        );
    }

    function it_throw_exception_if_error_is_return_from_api($client, ResponseInterface $response)
    {
        $response->getBody()->willReturn('{
            "error": {
                "message":"Invalid parameter",
                "type":"FacebookApiException",
                "code":100,
                "error_data":"No matching user found.",
                "fbtrace_id":"D2kxCybrKVw"
            }
        }');

        $client->request('POST', '/uri', Argument::any())->willReturn($response);

        $error = json_decode('
            {
                "message":"Invalid parameter",
                "type":"FacebookApiException",
                "code":100,
                "error_data":"No matching user found.",
                "fbtrace_id":"D2kxCybrKVw"
            }
        ', true);

        $this->shouldThrow(new ApiException('Invalid parameter', $error))->duringSend('POST', '/uri');
    }

    function it_catch_exception_from_client_($client)
    {
        $exception = new TransferException('Exception client');
        $client->request('POST', '/uri', Argument::any())->willThrow($exception);

        $this->shouldThrow(new ApiException('Exception client', [
            'code' => $exception->getCode(),
            'exception' => $exception,
        ]))->duringSend('POST', '/uri');
    }

    function it_can_set_text_welcome_message($client, ResponseInterface $response)
    {
        $options = [
            RequestOptions::QUERY => [
                'access_token' => 'token',
            ],
            RequestOptions::JSON => [
                'setting_type' => 'call_to_actions',
                'thread_state' => 'new_thread',
                'call_to_actions' => [
                    [
                        'message' => ['text' => 'Welcome'],
                    ],
                ],
            ],
        ];

        $response->getBody()->willReturn('
            {
                "result": "Successfully added new_thread\'s CTAs"
            }
        ');

        $client->request('POST', '/my_page_id/thread_settings', $options)
            ->willReturn($response);

        $this->setWelcomeMessage('Welcome', 'my_page_id')
            ->shouldHaveKeyWithValue('result', 'Successfully added new_thread\'s CTAs');
    }

    function it_can_set_welcome_message($client, Template $template, ResponseInterface $response)
    {
        $options = [
            RequestOptions::QUERY => [
                'access_token' => 'token',
            ],
            RequestOptions::JSON => [
                'setting_type' => 'call_to_actions',
                'thread_state' => 'new_thread',
                'call_to_actions' => [
                    [
                        'message' => ['attachment' => $template],

                    ],
                ],
            ],
        ];

        $response->getBody()->willReturn('
            {
                "result": "Successfully added new_thread\'s CTAs"
            }
        ');

        $client->request('POST', '/my_page_id/thread_settings', $options)
            ->willReturn($response);

        $this->setWelcomeMessage($template, 'my_page_id')
            ->shouldHaveKeyWithValue('result', 'Successfully added new_thread\'s CTAs');

    }

    function it_can_delete_welcome_message($client, ResponseInterface $response)
    {
        $options = [
            RequestOptions::QUERY => [
                'access_token' => 'token',
            ],
            RequestOptions::JSON => [
                'setting_type' => 'call_to_actions',
                'thread_state' => 'new_thread',
                'call_to_actions' => [],
            ],
        ];

        $response->getBody()->willReturn('
            {
                "result": "Successfully removed all new_thread\'s CTAs"
            }
        ');

        $client->request('POST', '/my_page_id/thread_settings', $options)
            ->willReturn($response);

        $this->deleteWelcomeMessage('my_page_id')
            ->shouldHaveKeyWithValue('result', 'Successfully removed all new_thread\'s CTAs');

    }

    function it_subscribe_the_app($client, ResponseInterface $response)
    {
        $options = [
            RequestOptions::QUERY => [
                'access_token' => 'token',
            ],
        ];

        $response->getBody()->willReturn('
            {
              "success": true
            }
        ');

        $client->request('POST', '/me/subscribed_apps', $options)
            ->willReturn($response);

        $this->subscribe()->shouldReturn(true);
    }
}
