<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-01 13:40:15 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-01 15:07:28
 */
namespace Y95201\Core;

use Y95201\Core\Arr;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
abstract class AbstractAPI
{
    /**
     * Http instance.
     */
    protected $http;

    /**
     * Config instance
     */
    protected $config;

    const SIGN_TYPE_RSA = 'RSA';
    const GET = 'get';
    const POST = 'post';
    const JSON = 'json';
    const PUT = 'put';
    const DELETE = 'delete';

    protected $baseUrl;

    protected $production = false;

    protected $timestamp;

    protected static $maxRetries = 0;

    /**
     * 构造器.
     */
    public function __construct(Config $config)
    {
        $this->timestamp = date('YmdHis');
        $this->setConfig($config);
    }

    /**
     * 返回当前配置
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 设置配置
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * 拼接地址
     */
    protected function url(string $url): string
    {
        return static::getBaseUrl() .  $url;
    }

    /**
     * 根据测试环境和生产环境选择URL
     */
    protected function getBaseUrl(): string
    {
        if (empty($this->baseUrl)) {
            $this->production = $this->getConfig()->get('production');
            if ($this->production) {
                $this->baseUrl = 'https://accpapi.lianlianpay.com/v1/';
            } else {
                $this->baseUrl = 'https://accpapi-ste.lianlianpay-inc.com/v1/';
            }
        }
        return $this->baseUrl;
    }

    /**
     * 返回json相应，及封装请求参数为json字符串格式.
     * @url 路由
     * @params 参数
     * @method 请求方式
     */
    protected function parse($url, $params, string $method = 'post')
    {
        // 获取http实例
        $http = $this->getHttp();
        $baseParams = [
            'timestamp' => $this->timestamp,
            'oid_partner' => $this->config['oid_partner']
        ];
        $params = array_merge($baseParams, $params);
        $params = $this->filterNull($params);
        $sign = $this->buildSignatureDataParams($params);
        $contents = $http->parseJSON(call_user_func_array([$http, $method], [$url, $params, $sign]));
        if (empty($contents)) {
            return null;
        }
        $this->checkAndThrow($contents);
        return $contents;
    }

    /**
     * 返回http实例
     */
    public function getHttp()
    {
        if (is_null($this->http)) {
            $this->http = new Http();
        }
        return $this->http;
    }

    /**
     * 过滤空参数
     */
    protected function filterNull($params): array
    {
        return Arr::where($params, function ($key, $value) {
            return !is_null($value);
        });
    }

    /**
     * 处理签名数据
     */
    protected function buildSignatureDataParams(array $params): string
    {
        $params = $this->filterNull($params);
        $signRaw = md5(json_encode($params, JSON_UNESCAPED_UNICODE));
        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($this->getConfig()->getInstantPayPrivateKey());
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($signRaw, $signStr, $res, OPENSSL_ALGO_MD5);
        //释放资源
        openssl_free_key($res);
        //base64编码   sign
        return base64_encode($signStr);
    }

    /**
     * 检查数组数据错误
     */
    protected function checkAndThrow(array $contents)
    {
        $successCodes = ['0000', '4002', '4003', '4004'];
        if (isset($contents['ret_code']) && !in_array($contents['ret_code'], $successCodes)) {
            if (empty($contents['ret_msg'])) {
                $contents['ret_msg'] = 'Unknown';
            }
        }
    }
}