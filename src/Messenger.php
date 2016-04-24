<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Tgallice\FBMessenger\Attachment\Structured;
use Tgallice\FBMessenger\Exception\ApiException;
use Tgallice\FBMessenger\Message\Message;
use Tgallice\FBMessenger\Model\MessageResponse;
use Tgallice\FBMessenger\Model\UserProfile;

class Messenger
{
    const API_BASE_URI = 'https://graph.facebook.com/v2.6';

    /**
     * @var string
     */
    private $token;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var ResponseInterface
     */
    private $lastResponse;

    /**
     * @param string $token
     * @param ClientInterface $client
     */
    public function __construct($token, ClientInterface $client = null)
    {
        $this->token = $token;
        $this->client = $client ?: new Client([
            'base_uri' => self::API_BASE_URI,
        ]);
    }

    /**
     * @param Message $message
     *
     * @return MessageResponse
     *
     * @throws ApiException
     */
    public function sendMessage(Message $message)
    {
        $options = RequestOptionsFactory::create($message);
        $decodedBody = $this->send('POST', '/me/messages', $options);

        return new MessageResponse(
            $decodedBody['recipient_id'],
            $decodedBody['message_id']
        );
    }

    /**
     * @param string $userId
     * @param array $fields
     *
     * @return UserProfile
     */
    public function getUserProfile(
        $userId,
        array $fields = [
            UserProfile::FIRST_NAME,
            UserProfile::LAST_NAME,
            UserProfile::PROFILE_PIC,
        ]
    ) {
        $options = [
            RequestOptions::QUERY => [
                'fields' => implode(',', $fields)
            ]
        ];

        $decodedBody = $this->send('GET', sprintf('/%s', $userId), $options);

        return UserProfile::create($decodedBody);
    }

    /**
     * @param string|Structured $message
     * @param string $pageId
     *
     * @return array
     */
    public function setWelcomeMessage($message, $pageId)
    {
        $type = is_string($message) ? 'text' : 'attachment';
        $options = [
            RequestOptions::JSON => [
                'setting_type' => 'call_to_actions',
                'thread_state' => 'new_thread',
                'call_to_actions' => [
                    [
                        'message' => [$type => $message],
                    ],
                ],
            ],
        ];

        return $this->send('POST', sprintf('/%s/thread_settings', $pageId), $options);
    }

    /**
     * @param string $pageId
     *
     * @return array
     */
    public function deleteWelcomeMessage($pageId)
    {
        $options = [
            RequestOptions::JSON => [
                'setting_type' => 'call_to_actions',
                'thread_state' => 'new_thread',
                'call_to_actions' => [],
            ],
        ];

        return $this->send('POST', sprintf('/%s/thread_settings', $pageId), $options);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     *
     * @return array
     *
     * @throws ApiException
     */
    public function send($method, $uri, array $options = [])
    {
        $options[RequestOptions::QUERY]['access_token'] = $this->token;

        try {
            $this->lastResponse = $this->client->request($method, $uri, $options);
            // Catch all Guzzle\Request exceptions
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), [
                'code' => $e->getCode(),
                'exception' => $e,
            ]);
        }

        $decodedBody = $this->decodeResponseBody($this->lastResponse);

        if (isset($decodedBody['error'])) {
            $message = isset($decodedBody['error']['message']) ? $decodedBody['error']['message'] : 'Unknown error';
            throw new ApiException($message, $decodedBody['error']);
        }

        return $decodedBody;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return null|array
     */
    private function decodeResponseBody(ResponseInterface $response)
    {
        return json_decode((string) $response->getBody(), true);
    }
}
