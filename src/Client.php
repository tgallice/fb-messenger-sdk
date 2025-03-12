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
    const DEFAULT_TIMEOUT = 60;

    /**
     * Request default file upload timeout
     */
    const DEFAULT_FILE_UPLOAD_TIMEOUT = 3600;

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

    public function __construct($accessToken, ?ClientInterface $httpClient = null)
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
    public function post($uri, $body = null)
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
     * @param mixed $data
     *
     * @return ResponseInterface
     */
    public function put($uri, $data = null)
    {
        return $this->send('PUT', $uri, $data);
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
     *
     * @throws ApiException
     */
    public function send($method, $uri, $body = null, array $query = [], array $headers = [], array $options = [])
    {
        $options = $this->enhanceOptions($body, $query, $headers, $options);

        try {
            $this->lastResponse = $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
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

    /**
     * @param ResponseInterface $response
     *
     * @throws ApiException
     */
    private function validateResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode((string) $response->getBody(), true);
            $code = isset($responseData['error']['code']) ? $responseData['error']['code'] : 0;
            $message = isset($responseData['error']['message']) ? $responseData['error']['message'] : $response->getReasonPhrase();

            throw new ApiException($message, $code, $responseData);
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
            'connect_timeout' => 10,
        ]);
    }

    private function enhanceOptions($body = null, array $query = [], array $headers = [], array $options = [])
    {
        // Add token
        if (!isset($query['access_token'])) {
            $query['access_token'] = $this->accessToken;
        }

        if (!empty($body) && is_array($body)) {
            // Encode and set the content type
            $body = json_encode($body);
            $headers['Content-Type'] = 'application/json';
        }

        $options[RequestOptions::BODY] = $body;
        $options[RequestOptions::QUERY] = $query;
        $options[RequestOptions::HEADERS] = $headers;

        return $options;
    }
}
