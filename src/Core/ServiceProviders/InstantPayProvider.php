<?php

namespace Y95201\LianLianPay\Foundation\ServiceProviders;

use Y95201\LianLianPay\InstantPay;
use Pimple\ServiceProviderInterface;

class InstantPayProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['instantPay'] = function ($pimple) {
            return new InstantPay\InstantPay($pimple['config']);
        };
    }
}