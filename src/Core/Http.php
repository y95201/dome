<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-01 14:41:03 
 * @Last Modified by:   Y95201 
 * @Last Modified time: 2022-04-01 14:41:03 
 */
namespace Y95201\Core;

use Y95201\Core\Log;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
class Http
{
    /**
     * Used to identify handler defined by client code
     * Maybe useful in the future.
     */
    const USER_DEFINED_HANDLER = 'userDefined';

    /**
     * Http client.
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * The middlewares.
     *
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var array
     */
    protected static $globals = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * Guzzle client default settings.
     *
     * @var array
     */
    protected static $defaults = [];

    /**
     * Set guzzle default settings.
     *
     * @param array $defaults
     */
    public static function setDefaultOptions($defaults = [])
    {
        self::$defaults = array_merge(self::$globals, $defaults);
    }

    /**
     * Return current guzzle default settings.
     *
     * @return array
     */
    public static function getDefaultOptions()
    {
        return self::$defaults;
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function get($url, array $options = [])
    {
        return $this->request($url, 'GET', ['query' => $options]);
    }

    public function put($url, $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';

        return $this->request($url, 'PUT', [$key => $options]);
    }

    public function delete($url, $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';

        return $this->request($url, 'DELETE', [$key => $options]);
    }

    /**
     * JSON request.
     *
     * @param string $url
     * @param string|array $options
     * @param array $queries
     *
     * @return ResponseInterface
     *
     * @throws HttpException|\GuzzleHttp\Exception\GuzzleException
     */
    public function json(string $url, $options = [], array $queries = []): ResponseInterface
    {
        is_array($options) && $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return $this->request($url, 'POST', ['query' => $queries, 'body' => $options, 'headers' => ['content-type' => 'application/json']]);
    }

    /**
     * JSON request.
     *
     * @param string $url
     * @param $signatureData
     * @param string|array $options
     * @param bool $headerSignature
     * @param array $queries
     * @return ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, $options, $signatureData, bool $headerSignature = true, array $queries = []): ResponseInterface
    {
        is_array($options) && $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        $header = [
            'content-type' => 'application/json;charset=utf-8',
        ];
        if ($headerSignature) {
            $header = array_merge($header, [
                'Signature-Type' => 'RSA',
                'Signature-Data' => $signatureData
            ]);
        }

        return $this->request($url, 'POST', ['query' => $queries, 'body' => $options, 'headers' => $header]);
    }

    /**
     * Upload file.
     *
     * @param string $url
     * @param array $files
     * @param array $form
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function upload($url, array $files = [], array $form = [], array $queries = [])
    {
        $multipart = [];

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request($url, 'POST', ['query' => $queries, 'multipart' => $multipart]);
    }

    /**
     * Set GuzzleHttp\Client.
     *
     * @param \GuzzleHttp\Client $client
     *
     * @return Http
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Return GuzzleHttp\Client instance.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (!($this->client instanceof HttpClient)) {
            $this->client = new HttpClient();
        }
        
        return $this->client;
    }

    /**
     * Add a middleware.
     *
     * @param callable $middleware
     *
     * @return $this
     */
    public function addMiddleware(callable $middleware)
    {
        array_push($this->middlewares, $middleware);

        return $this;
    }

    /**
     * Return all middlewares.
     *
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * Make a request.
     *
     * @param string $url
     * @param string $method
     * @param array $options
     *
     * @return ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = []): ResponseInterface
    {
        $method = strtoupper($method);
        
        $options = array_merge(self::$defaults, $options);
        
        //Log::debug('Client Request:', compact('url', 'method', 'options'));
        
        $options['handler'] = $this->getHandler();
        
        $response = $this->getClient()->request($method, $url, $options);

        // Log::debug('API response:', [
        //     'Status' => $response->getStatusCode(),
        //     'Reason' => $response->getReasonPhrase(),
        //     'Headers' => $response->getHeaders(),
        //     'Body' => strval($response->getBody()),
        // ]);
            
        return $response;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface|string $body
     *
     * @return mixed
     *
     * @throws HttpException
     */
    public function parseJSON($body)
    {
        
        if ($body instanceof ResponseInterface) {
            $body = mb_convert_encoding($body->getBody(), 'UTF-8');
        }

        if (empty($body)) {
            return false;
        }

        $contents = json_decode($body, true, 512, JSON_BIGINT_AS_STRING);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new HttpException('Failed to parse JSON: ' . json_last_error_msg());
        }

        return $contents;
    }

    /**
     * Build a handler.
     *
     * @return HandlerStack
     */
    protected function getHandler()
    {
        $stack = HandlerStack::create();

        foreach ($this->middlewares as $middleware) {
            $stack->push($middleware);
        }

        if (isset(static::$defaults['handler']) && is_callable(static::$defaults['handler'])) {
            $stack->push(static::$defaults['handler'], self::USER_DEFINED_HANDLER);
        }

        return $stack;
    }
}