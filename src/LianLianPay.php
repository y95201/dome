<?php

namespace Y95201\LianLianPay;

class LianLianPay 
{
    protected $providers = [
        // Payment\ServiceProvider::class,
        Account\ServiceProvider::class,
        // Common\ServiceProvider::class,
        // Secured\ServiceProvider::class,
        // Refund\ServiceProvider::class,
        // Withdrawal\ServiceProvider::class,
        // Password\ServiceProvider::class,
        // AccManage\ServiceProvider::class,
    ];
    public function __construct(array $config = array())
    {
        // parent::__construct($config);

        $this->config = function () use ($config) {
            return new Core\Config($config);
        };

        // $this->registerBase();
        // $this->registerProviders();
        // $this->initializeLogger();

        // Http::setDefaultOptions($this['config']->get('guzzle', ['timeout' => 5.0]));

        // $this->logConfiguration($config);
    }
    public function LianLianPay()
    {
        return $this->providers;
    }
    // public function __get($name)
    // {
    //     return $this->offsetGet($name);
    // }

    // public function __set($name, $value)
    // {
    //     $this->offsetSet($name, $value);
    // }
}