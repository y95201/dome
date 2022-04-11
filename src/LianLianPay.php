<?php
/*
 * @Author: Y95201 
 * @Date: 2022-03-29 13:59:46 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-08 13:11:01
 */
namespace Y95201;
use Y95201\Core\Http;
class LianLianPay extends \Pimple\Container
{
    protected $providers = [
        AccManage\ServiceProvider::class,
        Account\ServiceProvider::class,
        Password\ServiceProvider::class,
        Payment\ServiceProvider::class,
        Secured\ServiceProvider::class,
        Withdrawal\ServiceProvider::class,
    ];
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this['config'] = function () use ($config) {
            return new Core\Config($config);
        };
        
        Http::setDefaultOptions($this['config']->get('guzzle', ['timeout' => 5.0]));
        $this->registerProviders();
    }
    public function __get($id)
    {
        return $this->offsetGet($id);
    }
    public function __set($id, $value)
    {
        $this->offsetSet($id,$value);
    }
    private function registerProviders()
    {
        foreach ($this->providers as $provider){
            $this->register(new $provider());
        }
    }
}