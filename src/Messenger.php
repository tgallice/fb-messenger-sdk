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
        $responseData = $this->send('POST', '/me/messages', $options);

        return new MessageResponse($responseData['recipient_id'], $responseData['message_id']);
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

        $responseData = $this->send('GET', sprintf('/%s', $userId), $options);

        return UserProfile::create($responseData);
    }

    /**
     * @param string|Structured $message
     * @param string $pageId
     *
     * @return array
     */
    public function setWelcomeMessage($message, $pageId)
    {
        $options = [
            RequestOptions::JSON => $this->buildWelcomeData($message),
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
            RequestOptions::JSON => $this->buildWelcomeData(),
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
        try {
            $response = $this->client->request($method, $uri, $this->buildOptions($options));
            // Catch all Guzzle\Request exceptions
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), [
                'code' => $e->getCode(),
                'exception' => $e,
            ]);
        }

        $this->lastResponse = $response;

        return $this->getResponseData($response);
    }

    /**
     * Return the decoded body data
     *
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws ApiException
     */
    private function getResponseData(ResponseInterface $response)
    {
        $responseData = $this->decodeResponseBody($response);

        if (isset($responseData['error'])) {
            $message = isset($responseData['error']['message']) ? $responseData['error']['message'] : 'Unknown error';
            throw new ApiException($message, $responseData['error']);
        }

        return $responseData;
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

    /**
     * @param array $options
     *
     * @return array
     */
    private function buildOptions(array $options = [])
    {
        $options[RequestOptions::QUERY]['access_token'] = $this->token;

        return $options;
    }

    /**
     * @param mixed $message
     *
     * @return array
     */
    private function buildWelcomeData($message = null)
    {
        $data = [
            'setting_type' => 'call_to_actions',
            'thread_state' => 'new_thread',
            'call_to_actions' => [],
        ];

        if (null === $message) {
            return $data;
        }

        $type = is_string($message) ? 'text' : 'attachment';

        $data['call_to_actions'][] = [
            'message' => [$type => $message],
        ];

        return $data;
    }
}
