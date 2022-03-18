<?php

namespace Y95201\LianLianPay\Account;

class ServiceProvider 
{
    public function register(Container $pimple)
    {
        $pimple['account'] = function ($pimple) {
            return new Client($pimple['config']);
        };
    }
}