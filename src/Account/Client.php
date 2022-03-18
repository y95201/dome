<?php

namespace Y95201\LianLianPay\Account;

class Client 
{
    /**
     * 绑定手机验证码申请
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/regphone-verifycode-apply.html
     * @param $userId
     * @param $regPhone
     * @param null $timestamp
     * @return Collection|null
     * @throws HttpException
     */
    public function phoneVerifyCodeApply($userId = null, $regPhone = null, $timestamp = null)
    {
    	return 123456789;
        // $params = [
        //     'timestamp' => $timestamp ?: $this->timestamp,
        //     'oid_partner' => $this->config['oid_partner'],
        //     'user_id' => $userId,
        //     'reg_phone' => $regPhone
        // ];
        // return $this->parse($this->url('acctmgr/regphone-verifycode-apply'), $params);
    }
}