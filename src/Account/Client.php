<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-03 09:59:28 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-03 14:59:37
 */
namespace Y95201\Account;
class Client extends \Y95201\Core\AbstractAPI
{
    public function phoneVerifyCodeApply($userId, $regPhone)
    {
    	$params = [
            'user_id' => $userId,
            'reg_phone' => $regPhone
        ];
        return $this->parse($this->url('acctmgr/regphone-verifycode-apply'), $params);
    }
}