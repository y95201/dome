<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-08 12:51:25 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-08 19:15:03
 */

namespace Y95201\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
class Log
{
    public static function trace($file,string $msg = '',array $params = [], string $level = 'DEBUG')
    {
        switch ($level) {
            case 'DEBUG':
                $level = Logger::DEBUG;
                break;
            default:
                $level = Logger::DEBUG;
                break;
        }
        // 创建日志频道
        $logger = new Logger('lianlianpay');
        //创建日志路径
        $logger->pushHandler(new StreamHandler($file, $level));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info($msg ?? '', $params ?? []);
    }
}