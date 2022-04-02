<?php
/*
 * @Author: Y95201 
 * @Date: 2022-03-23 09:59:35 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-03-31 14:04:05
 */
namespace Y95201\Account;
class ServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['account'] = function ($pimple) {
            return new Client($pimple['config']);
        };
    }
}