<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Tgallice\FBMessenger\Exception\ApiException;
use Tgallice\FBMessenger\Model\Message;
use Tgallice\FBMessenger\Model\MessageResponse;
use Tgallice\FBMessenger\Model\UserProfile;

class Messenger
{
    use ResponseHandler;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param string $token
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $recipient
     * @param Message $message
     * @param string $notificationType
     *
     * @return MessageResponse
     *
     * @throws ApiException
     */
    public function sendMessage($recipient, Message $message, $notificationType = NotificationType::REGULAR)
    {
        $options = RequestOptionsFactory::createForMessage($recipient, $message, $notificationType);
        $response = $this->client->send('POST', '/me/messages', null, [], [], $options);
        $responseData = $this->decodeResponse($response);

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
     * @param string|Template $message
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
     * Subscribe the app to the page
     *
     * @return bool
     */
    public function subscribe()
    {
        $response = $this->client->post('/me/subscribed_apps');
        $decoded = $this->decodeResponse($response);

        return $decoded['success'];
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
