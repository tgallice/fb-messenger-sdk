<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * API base uri
     */
    const API_BASE_URI = 'https://graph.facebook.com/';

    /*
     * API Version
     */
    const DEFAULT_API_VERSION = 'v2.6';

    /**
     * Request default timeout
     */
    const DEFAULT_TIMEOUT = 5;

    /**
     * @var array
     */
    public static $allowedMethod = ['POST', 'GET', 'PUT', 'DELETE'];

    /**
     * @var string Wit app token
     */
    private $accessToken;

    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @var ClientInterface client
     */
    private $client;

    /**
     * @var ResponseInterface|null
     */
    private $lastResponse;

    public function __construct($accessToken, ClientInterface $httpClient = null, $apiVersion = self::DEFAULT_API_VERSION)
    {
        $this->accessToken = $accessToken;
        $this->apiVersion = $apiVersion;
        $this->client = $httpClient ?: $this->defaultHttpClient();
    }

    /**
     * @param string $uri
     * @param array $params
     *
     * @return ResponseInterface
     */
    public function post($uri, array $params = [])
    {
        return $this->send('POST', $uri, $params);
    }

    /**
     * @param string $uri
     * @param array $params
     *
     * @return ResponseInterface
     */
    public function get($uri, array $params = [])
    {
        return $this->send('GET', $uri, null, $params);
    }

    /**
     * @param string $uri
     * @param array $params
     *
     * @return ResponseInterface
     */
    public function put($uri, array $params = [])
    {
        return $this->send('PUT', $uri, $params);
    }

    /**
     * @param string $uri
     *
     * @return ResponseInterface
     */
    public function delete($uri)
    {
        return $this->send('DELETE', $uri);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $body
     * @param array $query
     * @param array $headers
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function send($method, $uri, $body = null, array $query = [], array $headers = [], array $options = [])
    {
        $headers = array_merge($this->getDefaultHeaders(), $headers);

        $query = $this->addToken($query);

        $this->lastResponse = $this->client->send($method, $uri, $body, $query, $headers, $options);
        $this->validateResponse($this->lastResponse);

        return $this->lastResponse;
    }

    /**
     * Get the last response from the API
     *
     * @return null|ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function getHttpClient()
    {
        return $this->client;
    }

    private function addToken(array $query)
    {
        $query['acccess_token'] = $this->accessToken;

        return $query;
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws BadResponseException
     */
    private function validateResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            $message = empty($response->getReasonPhrase()) ? 'Bad response status code' : $response->getReasonPhrase();

            throw new BadResponseException($message, $response);
        }
    }

    /**
     * @return ClientInterface
     */
    private function defaultHttpClient()
    {
        return new \GuzzleHttp\Client([
            'base_uri' => self::API_BASE_URI . $this->apiVersion,
            'timeout' => self::DEFAULT_TIMEOUT,
            'connect_timeout' => self::DEFAULT_TIMEOUT,
        ]);
    }
}
