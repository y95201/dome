<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-01 13:41:03 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-08 16:55:59
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
     * Guzzle客户端默认设置.
     */
    protected static $defaults = [];

    /**
     * 设置guzzle默认设置.
     */
    public static function setDefaultOptions($defaults = [])
    {
        self::$defaults = array_merge(self::$globals, $defaults);
    }

    /**
     * 返回当前的guzzle默认设置.
     */
    public static function getDefaultOptions()
    {
        return self::$defaults;
    }

    /**
     * GET请求.
     * @url string 
     * @options array 
     */
    public function get($url, array $options = [])
    {
        return $this->request($url, 'GET', ['query' => $options]);
    }
    
    /**
     * PUT请求.
     * @url string 
     * @options array 
     */
    public function put($url, $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';
        return $this->request($url, 'PUT', [$key => $options]);
    }
    /**
     * DELETE请求.
     * @url string 
     * @options array 
     */
    public function delete($url, $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';
        return $this->request($url, 'DELETE', [$key => $options]);
    }

    /**
     * JSON请求.
     * @url string $url
     * @options string|array $options
     * @queries array $queries
     */
    public function json(string $url, $options = [], array $queries = []): ResponseInterface
    {
        is_array($options) && $options = json_encode($options, JSON_UNESCAPED_UNICODE);
        return $this->request($url, 'POST', ['query' => $queries, 'body' => $options, 'headers' => ['content-type' => 'application/json']]);
    }

    /**
     * JSON request.
     * @url string $url
     * @signatureData $signatureData
     * @options string|array $options
     * @headerSignature bool $headerSignature
     * @queries array $queries
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
     * @url string $url
     * @files array $files
     * @form array $form
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
     * 设置http\Client.
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * 返回http\Client实例.
     */
    public function getClient()
    {
        if (!($this->client instanceof HttpClient)) {
            $this->client = new HttpClient();
        }
        return $this->client;
    }

    /**
     * 添加一个中间件.
     */
    public function addMiddleware(callable $middleware)
    {
        array_push($this->middlewares, $middleware);
        return $this;
    }

    /**
     * 退回所有中间件.
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * 请求.
     * @url string $url
     * @method string $method
     * @options array $options
     */
    public function request(string $url, string $method = 'GET', array $options = []): ResponseInterface
    {
        $method = strtoupper($method);
        $options = array_merge(self::$defaults, $options);
        $options['handler'] = $this->getHandler();
        $response = $this->getClient()->request($method, $url, $options);
        return $response;
    }

    /**
     * 转json
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
        return $contents;
    }

    /**
     * 构建一个处理程序.
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