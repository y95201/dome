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
    /**
     * 绑定手机验证码申请
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/regphone-verifycode-apply.html
     * @param $userId
     * @param $regPhone
     */
    public function phoneVerifyCodeApply($userId, $regPhone)
    {
    	$params = [
            'user_id' => $userId,
            'reg_phone' => $regPhone
        ];
        return $this->parse($this->url('acctmgr/regphone-verifycode-apply'), $params);
    }

     /**
     * 绑定手机验证码验证
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/regphone-verifycode-verify.html
     * @param $userId // 用户在商户系统中的唯一编号
     * @param $regPhone // 绑定手机号。用户开户注册绑定手机号
     * @param $verifyCode // 绑定手机号验证码 通过绑定手机验证码申请接口申请发送给用户绑定手机的验证码
      */
    public function phoneVerifyCodeVerify($userId, $regPhone, $verifyCode)
    {
        $params = [
            'user_id' => $userId,
            'verify_code' => $verifyCode,
            'reg_phone' => $regPhone
        ];
        return $this->parse($this->url('acctmgr/regphone-verifycode-verify'), $params);
    }

    /**
     * 个人用户开户申请
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/openacct-apply-individual.html
     * @param $params
     */
    public function personOpenAcctApply($params)
    {
        return $this->parse($this->url('acctmgr/openacct-apply-individual'), $params);
    }

    /**
     * 企业用户开户验证
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/openacct-verify-enterprise.html
     * @param $params
     */
    public function enterpriseOpenAcctVerify($params)
    {
        return $this->parse($this->url('acctmgr/openacct-verify-enterprise'), $params);
    }

    /**
     * 文件上传
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/upload.html
     * @param $params
     * @return Collection|null
     * @throws HttpException
     */
    public function upload($params)
    {
        return $this->parse($this->url('documents/upload'), $params);
    }

    /**
     * 上传照片
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/upload-photos.html
     * @param $params
     * @return Collection|null
     * @throws HttpException
     */
    public function uploadPhotos($params)
    {
        return $this->parse($this->url('acctmgr/upload-photos'), $params);
    }

    /**
     * 用户开户申请(页面接入)
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/openacct-apply.html
     * @param array $params
     */
    public function openAcctApply(array $params)
    {
        return $this->parse($this->url('acctmgr/openacct-apply'), $params);
    }

    /**
     * 个人用户信息修改
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/modify-userinfo-individual.html
     * @param array $params
     */
    public function modifyPersonUserInfo(array $params)
    {
        return $this->parse($this->url('acctmgr/modify-userinfo-individual'), $params);
    }

    /**
     * 企业用户信息修改
     * @doc https://open.lianlianpay.com/docs/accp/accpstandard/modify-userinfo-enterprise.html
     * @param array $params
     */
    public function modifyEnterpriseUserInfo(array $params)
    {
        return $this->parse($this->url('acctmgr/modify-userinfo-enterprise'), $params);
    }
}