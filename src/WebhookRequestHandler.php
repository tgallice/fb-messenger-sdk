<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\RequestInterface;
use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\Model\Callback\Entry;

class WebhookRequestHandler
{
    /**
     * @var RequestInterface
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
     * @param string $secret
     * @param RequestInterface|null $request
     */
    public function __construct($secret, RequestInterface $request = null)
    {
        $this->secret = $secret;
        $this->request = null === $request ? ServerRequest::fromGlobals() : $request;
    }

    /**
     * Check if the request is a valid webhook request
     *
     * @return bool
     */
    public function isValid()
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
     * @return RequestInterface
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
        if (isset($this->body )) {
            return $this->body;
        }

        // Reset pointer to the beginning
        $this->request->getBody()->rewind();
        $this->body = $this->request->getBody()->getContents();
        $this->request->getBody()->rewind();

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
