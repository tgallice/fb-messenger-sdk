<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\Callback\MessageEvent;
use Tgallice\FBMessenger\Callback\PostbackEvent;
use Tgallice\FBMessenger\Model\Callback\Entry;

class WebhookRequestHandler
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * App secret used to verify the request sha1
     *
     * @var string
     */
    private $secret;

    /**
     * @var array
     */
    private $decodedBody;

    /**
     * @var Entry[]
     */
    private $hydratedEntries;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $verifyToken;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param $secret
     * @param $verifyToken
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct($secret, $verifyToken, ?EventDispatcherInterface $dispatcher = null)
    {
        $this->secret = $secret;
        $this->verifyToken = $verifyToken;
        $this->dispatcher = $dispatcher ?: new EventDispatcher();
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function handleRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Check if the token match with the given verify token.
     * This is useful in the webhook setup process.
     *
     * @return bool
     */
    public function isValidVerifyTokenRequest()
    {
        if ($this->getRequest()->getMethod() !== 'GET') {
            return false;
        }

        $params = $this->getRequest()->getQueryParams();

        if (!isset($params['hub_verify_token'])) {
            return false;
        }

        return  $params['hub_verify_token'] === $this->verifyToken;
    }

    /**
     * @return null|string
     */
    public function getChallenge()
    {
        $params = $this->getRequest()->getQueryParams();

        return isset($params['hub_challenge']) ? $params['hub_challenge'] : null;
    }

    public function isValidInstagramCallbackRequest()
    {
        if (!$this->isValidHubSignature()) {
            return false;
        }

        $decoded = $this->getDecodedBody();

        $object = isset($decoded['object']) ? $decoded['object'] : null;
        $entry = isset($decoded['entry']) ? $decoded['entry'] : null;

        return $object === 'instagram' && null !== $entry;
    }

    public function isValidWhatsAppCallbackRequest()
    {
        if (!$this->isValidHubSignature()) {
            return false;
        }

        $decoded = $this->getDecodedBody();

        $object = isset($decoded['object']) ? $decoded['object'] : null;
        $entry = isset($decoded['entry']) ? $decoded['entry'] : null;

        return $object === 'whatsapp_business_account' && null !== $entry;
    }

    /**
     * Check if the request is a valid webhook request
     *
     * @return bool
     */
    public function isValidCallbackRequest()
    {
        if (!$this->isValidHubSignature()) {
            return false;
        }

        $decoded = $this->getDecodedBody();

        $object = isset($decoded['object']) ? $decoded['object'] : null;
        $entry = isset($decoded['entry']) ? $decoded['entry'] : null;

        return $object === 'page' && null !== $entry;
    }

    /**
     * Check if the request is a valid webhook request
     *
     * @deprecated use WebhookRequestHandler::isValidCallbackRequest() instead
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isValidCallbackRequest();
    }

    /**
     * @return CallbackEvent[]
     */
    public function getAllCallbackEvents()
    {
        $events = [];

        foreach ($this->getHydratedEntries() as $hydratedEntry) {
            $events = array_merge($events, $hydratedEntry->getCallbackEvents());
        }

        return $events;
    }

    /**
     * @return Entry[]
     */
    public function getEntries()
    {
        return $this->getHydratedEntries();
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        if ($this->request) {
            return $this->request;
        }

        return $this->request = ServerRequest::fromGlobals();
    }

    /**
     * @return array
     */
    public function getDecodedBody()
    {
        if (isset($this->decodedBody)) {
            return $this->decodedBody;
        }

        $decoded = @json_decode($this->getBody(), true);

        return $this->decodedBody = null === $decoded ? [] : $decoded;
    }

    /**
     * Dispatch events to listeners
     */
    public function dispatchCallbackEvents()
    {
        foreach ($this->getAllCallbackEvents() as $event) {
            $this->dispatcher->dispatch($event->getName(), $event);

            if ($event instanceof PostbackEvent) {
                // Dispatch postback payload
                $this->dispatcher->dispatch($event->getPostback()->getPayload(), $event);
            }

            if ($event instanceof MessageEvent && $event->isQuickReply()) {
                // Dispatch quick reply payload
                $this->dispatcher->dispatch($event->getQuickReplyPayload(), $event);
            }
        }
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    /**
     * @return Entry[]
     */
    private function getHydratedEntries()
    {
        if (isset($this->hydratedEntries)) {
            return $this->hydratedEntries;
        }

        $decodedBody = $this->getDecodedBody();
        $entries = $decodedBody['entry'];

        $hydrated = [];

        foreach ($entries as $entry) {
            $hydrated[] = Entry::create($entry);
        }

        return $this->hydratedEntries = $hydrated;
    }

    /**
     * @return string
     */
    private function getBody()
    {
        if (isset($this->body)) {
            return $this->body;
        }

        $this->body = (string) $this->getRequest()->getBody();

        return $this->body;
    }

    /**
     * @return bool
     */
    private function isValidHubSignature()
    {
        if (isset($_SERVER['HTTP_X_HUB_SIGNATURE'])){
            $headers = array();
            $headers[] = $_SERVER['HTTP_X_HUB_SIGNATURE'];
        } else {
            $headers = $this->getRequest()->getHeader('X-Hub-Signature');
        }

        if (empty($headers)) {
            return false;
        }

        $signature = XHubSignature::parseHeader($headers[0]);

        return XHubSignature::validate($this->getBody(), $this->secret, $signature);
    }
}
