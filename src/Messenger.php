<?php

namespace Tgallice\FBMessenger;

use Tgallice\FBMessenger\Exception\ApiException;
use Tgallice\FBMessenger\Model\Attachment;
use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Button;
use Tgallice\FBMessenger\Model\Message;
use Tgallice\FBMessenger\Model\MessageResponse;
use Tgallice\FBMessenger\Model\ThreadSetting;
use Tgallice\FBMessenger\Model\ThreadSetting\GreetingText;
use Tgallice\FBMessenger\Model\ThreadSetting\StartedButton;
use Tgallice\FBMessenger\Model\UserProfile;

class Messenger
{
    use ResponseHandler;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $recipient
     * @param string|Message|Attachment|Template $message
     * @param string $notificationType
     *
     * @return MessageResponse
     *
     * @throws ApiException
     */
    public function sendMessage($recipient, $message, $notificationType = NotificationType::REGULAR)
    {
        $message = $this->createMessage($message);
        $options = RequestOptionsFactory::createForMessage($recipient, $message, $notificationType);
        $response = $this->client->send('POST', '/me/messages', null, [], [], $options);
        $responseData = $this->decodeResponse($response);

        return new MessageResponse($responseData['recipient_id'], $responseData['message_id']);
    }

    /**
     * @param string $recipient
     * @param string $typingIndicator
     */
    public function setTypingStatus($recipient, $typingIndicator) {
        $options = RequestOptionsFactory::createForTyping($recipient, $typingIndicator);
        $this->client->send('POST', '/me/messages', null, [], [], $options);
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
            UserProfile::LOCALE,
            UserProfile::TIMEZONE,
            UserProfile::GENDER,
            UserProfile::PAYMENT_ENABLED,
        ]
    ) {
        $query = [
            'fields' => implode(',', $fields)
        ];

        $response = $this->client->get(sprintf('/%s', $userId), $query);
        $data = $this->decodeResponse($response);

        return UserProfile::create($data);
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
     * @param Button[] $menuButtons
     */
    public function setPersistentMenu(array $menuButtons)
    {
        if (count($menuButtons) > 5) {
            throw new \InvalidArgumentException('You should not set more than 5 menu items.');
        }

        $setting = $this->buildSetting(
            ThreadSetting::TYPE_CALL_TO_ACTIONS,
            ThreadSetting::EXISTING_THREAD,
            $menuButtons
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

    public function deleteGreetingText()
    {
        $setting = $this->buildSetting(ThreadSetting::TYPE_GREETING);

        $this->deleteThreadSettings($setting);
    }

    /**
     * Messenger Factory
     *
     * @param string $token
     *
     * @return Messenger
     */
    public static function create($token)
    {
        $client = new Client($token);

        return new self($client);
    }


    /**
     * @param array $setting
     */
    private function postThreadSettings(array $setting)
    {
        $this->client->post('/me/thread_settings', $setting);
    }

    /**
     * @param array $setting
     */
    private function deleteThreadSettings(array $setting)
    {
        $this->client->send('DELETE', '/me/thread_settings', $setting);
    }

    /**
     * @param string $type
     * @param null|string $threadState
     * @param mixed $value
     *
     * @return array
     */
    private function buildSetting($type, $threadState = null, $value = null)
    {
        $setting = [
            'setting_type' => $type,
        ];

        if (!empty($threadState)) {
            $setting['thread_state'] = $threadState;
        }

        if (!empty($value)) {
            $setting[$type] = $value;
        }

        return $setting;
    }

    /**
     * @param string|Message|Attachment|Template $message
     *
     * @return Message
     */
    private function createMessage($message)
    {
        if ($message instanceof Message) {
            return $message;
        }

        if ($message instanceof Template) {
            $message = new Attachment(Attachment::TYPE_TEMPLATE, $message);
        }

        if (is_string($message) || $message instanceof Attachment) {
            return new Message($message);
        }

        throw new \InvalidArgumentException('$message should be a string, Message, Attachment or Template');
    }
}
