<?php

namespace Tgallice\FBMessenger;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Tgallice\FBMessenger\Exception\ApiException;

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
     * @var ClientInterface client
     */
    private $client;

    /**
     * @var ResponseInterface|null
     */
    private $lastResponse;

    public function __construct($accessToken, ClientInterface $httpClient = null)
    {
        $this->accessToken = $accessToken;
        $this->client = $httpClient ?: $this->defaultHttpClient();
    }

    /**
     * @param string $uri
     * @param mixed $body
     *
     * @return ResponseInterface
     */
    public function post($uri, $body)
    {
        return $this->send('POST', $uri, $body);
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
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function delete($uri, array $options = [])
    {
        return $this->send('DELETE', $uri, null, [], [], $options);
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
     *
     * @throws ApiException
     */
    public function send($method, $uri, $body = null, array $query = [], array $headers = [], array $options = [])
    {
        $query = $this->addToken($query);

        try {
            $options[RequestOptions::BODY] = $body;
            $options[RequestOptions::QUERY] = $query;
            $options[RequestOptions::HEADERS] = array_merge($this->defaultHeaders(), $headers);

            $this->lastResponse = $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getTrace());
        }

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
        $query['access_token'] = $this->accessToken;

        return $query;
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ApiException
     */
    private function validateResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            $message = empty($response->getReasonPhrase()) ? 'Bad response status code' : $response->getReasonPhrase();
            $responseData = json_decode((string) $response->getBody(), true);

            throw new ApiException($message, $responseData);
        }
    }

    /**
     * @return ClientInterface
     */
    private function defaultHttpClient()
    {
        return new \GuzzleHttp\Client([
            'base_uri' => self::API_BASE_URI . self::DEFAULT_API_VERSION,
            'timeout' => self::DEFAULT_TIMEOUT,
            'connect_timeout' => self::DEFAULT_TIMEOUT,
        ]);
    }

    private function defaultHeaders()
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
