<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Tgallice\FBMessenger\Callback\CallbackEvent;
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
     * @param string $secret
     * @param string $verifyToken
     * @param ServerRequestInterface|null $request
     */
    public function __construct($secret, $verifyToken, ServerRequestInterface $request = null)
    {
        $this->secret = $secret;
        $this->verifyToken = $verifyToken;
        $this->request = null === $request ? ServerRequest::fromGlobals() : $request;
    }

    /**
     * Check if the token match with the given verify token.
     * This is useful in the webhook setup process.
     *
     * @return bool
     */
    public function isValidVerifyTokenRequest()
    {
        if ($this->request->getMethod() !== 'GET') {
            return false;
        }

        $params = $this->request->getQueryParams();

        if (!isset($params['hub.verify_token'])) {
            return false;
        }

        return  $params['hub.verify_token'] === $this->verifyToken;
    }

    /**
     * @return null|string
     */
    public function getChallenge()
    {
        $params = $this->request->getQueryParams();

        return isset($params['hub.challenge']) ? $params['hub.challenge'] : null;
    }

    /**
     * Check if the request is a valid webhook request
     *
     * @return bool
     */
    public function isValidCallbackRequest()
    {
        if (!$this->isValidHeader()) {
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
        return $this->request;
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

        $this->body = (string) $this->request->getBody();

        return $this->body;
    }

    /**
     * @return bool
     */
    private function isValidHeader()
    {
        $headers = $this->request->getHeader('X-Hub-Signature');

        if (empty($headers)) {
            return false;
        }

        $signature = XHubSignature::parseHeader($headers[0]);

        return XHubSignature::validate($this->getBody(), $this->secret, $signature);
    }
}
