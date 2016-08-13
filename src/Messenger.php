<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\RequestOptions;
use Tgallice\FBMessenger\Exception\ApiException;
use Tgallice\FBMessenger\Model\Message;
use Tgallice\FBMessenger\Model\MessageResponse;
use Tgallice\FBMessenger\Model\ThreadSetting;
use Tgallice\FBMessenger\Model\ThreadSetting\GreetingText;
use Tgallice\FBMessenger\Model\ThreadSetting\StartedButton;
use Tgallice\FBMessenger\Model\ThreadSetting\MenuItem;
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
     * @param $text
     */
    public function setGreetingText($text)
    {
        $greeting = new GreetingText($text);
        $setting = $this->buildSetting(ThreadSetting::TYPE_GREETING, null, $greeting);

        $this->postThreadSettings($setting);
    }

    /**
     * @param string $payload
     */
    public function setStartedButton($payload)
    {
        $startedButton = new StartedButton($payload);
        $setting = $this->buildSetting(
            ThreadSetting::TYPE_CALL_TO_ACTIONS,
            ThreadSetting::NEW_THREAD,
            [$startedButton]
        );

        $this->postThreadSettings($setting);
    }

    public function deleteStartedButton()
    {
        $setting = $this->buildSetting(
            ThreadSetting::TYPE_CALL_TO_ACTIONS,
            ThreadSetting::NEW_THREAD
        );

        $this->deleteThreadSettings($setting);
    }

    /**
     * @param MenuItem[] $menuItems
     */
    public function setPersistentMenu(array $menuItems)
    {
        if (count($menuItems) > 5) {
            throw new \InvalidArgumentException('You should not set more than 5 menu items.');
        }

        $setting = $this->buildSetting(
            ThreadSetting::TYPE_CALL_TO_ACTIONS,
            ThreadSetting::EXISTING_THREAD,
            $menuItems
        );

        $this->postThreadSettings($setting);
    }

    public function deletePersistentMenu()
    {
        $setting = $this->buildSetting(
            ThreadSetting::TYPE_CALL_TO_ACTIONS,
            ThreadSetting::EXISTING_THREAD
        );

        $this->deleteThreadSettings($setting);
    }

    /**
     * @param array $setting
     */
    private function postThreadSettings(array $setting)
    {
        $this->client->post('/me/thread_settings', json_encode($setting));
    }

    /**
     * @param array $setting
     */
    private function deleteThreadSettings(array $setting)
    {
        $this->client->send('DELETE', '/me/thread_settings', json_encode($setting));
    }

    /**
     * @param string $type
     * @param null|string $threadState
     * @param array $value
     *
     * @return array
     */
    private function buildSetting($type, $threadState = null, array $value = [])
    {
        $setting = [
            'setting_type' => $type,
        ];

        if ($threadState) {
            $setting['thread_state'] = $threadState;
        }

        if (!empty($value)) {
            $setting[$type] = $value;
        }

        return $setting;
    }
}
