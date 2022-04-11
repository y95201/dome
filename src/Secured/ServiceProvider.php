<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-03 09:59:35 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-03 14:04:05
 */
namespace Y95201\Secured;
class ServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['secured'] = function ($pimple) {
            return new Client($pimple['config']);
        };
    }
}