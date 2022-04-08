<?php
require "vendor/autoload.php";
use Y95201\LianLianPay;
$config = [
    'debug' => true, // 开启调
    'oid_partner' => '2020042200284052', // 商户号
    'private_key' => file_get_contents('merchant_rsa_private_key.pem'), // 商户私钥 地址自行配置，绝对路径
    'public_key' => file_get_contents('merchant_rsa_public_key.pem'), // 商户公钥
    'll_public_key' => file_get_contents('llpay_public_key.pem'), // 连连支付公钥
    'production' => '', // 是否生产环境 有值为生产 无值为测试
    // 日志
    'log' => [
        'level' => 'debug',
        'permission' => 0777,
        'file' => 'logs/lianlianpay-' . date('Y-m-d') . '.log', // 日志文件, 你可以自定义
    ],
];

$llp = new \Y95201\LianLianPay($config);
// print_r($llp);die;
$result = $llp->account->phoneVerifyCodeApply('111','13023667672'); 
