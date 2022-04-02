<?php
/*
 * @Author: Y95201 
 * @Date: 2022-03-23 09:59:46 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-03-31 15:25:25
 */
namespace Y95201;
class LianLianPay extends \Pimple\Container
{
    protected $providers = [
        Account\ServiceProvider::class,
    ];
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this['config'] = function () use ($config) {
            return new Core\Config($config);
        };
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