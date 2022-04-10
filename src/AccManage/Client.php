<?php
/*
 * @Author: Y95201 
 * @Date: 2022-04-03 09:59:35 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-04-03 14:04:05
 */
namespace Y95201\Account;
class Client extends \Y95201\Core\AbstractAPI
{
    /**
     * 个人用户新增绑卡
     * https://open.lianlianpay.com/docs/accp/accpstandard/individual-bindcard-apply.html
     * @param array $params
     */
    public function personBindCardApply(array $params)
    {
        return $this->parse($this->url('acctmgr/individual-bindcard-apply'), $params);
    }

    /**
     * 绑卡验证
     * https://open.lianlianpay.com/docs/accp/accpstandard/individual-bindcard-verify.html
     * @param string $userId 用户在商户系统中的唯一编号，要求该编号在商户系统能唯一标识用户。由商户自定义。
     * @param string $txnSeqno 商户系统唯一交易流水号。由商户自定义。
     * @param string $token 授权令牌，有效期为30分钟
     * @param string $verifyCode 短信验证码。验证银行预留手机号
     */
    public function personBindCardVerify(string $userId, string $txnSeqno, string $token, string $verifyCode)
    {
        $params = [
            'user_id' => $userId,
            'txn_seqno' => $txnSeqno,
            'token' => $token,
            'verify_code' => $verifyCode
        ];
        return $this->parse($this->url('acctmgr/individual-bindcard-verify'), $params);
    }

    /**
     * 个人用户解绑银行卡
     * https://open.lianlianpay.com/docs/accp/accpstandard/unlinkedacct-ind-apply.html
     * @param array $params
     */
    public function unbindCardApply(array $params)
    {
        return $this->parse($this->url('acctmgr/unlinkedacct-ind-apply'), $params);
    }

    /**
     * 企业用户更换绑定账号申请
     * https://open.lianlianpay.com/docs/accp/accpstandard/enterprise-changecard-apply.html
     * @param array $params
     */
    public function enterpriseChangeCardApply(array $params)
    {
        return $this->parse($this->url('acctmgr/enterprise-changecard-apply'), $params);
    }

    /**
     * 企业用户更换绑定账号验证
     * https://open.lianlianpay.com/docs/accp/accpstandard/enterprise-changecard-verify.html
     * @param string $userId 用户在商户系统中的唯一编号，要求该编号在商户系统能唯一标识用户。由商户自定义。
     * @param string $txnSeqno 商户系统唯一交易流水号。由商户自定义。
     * @param string $token 授权令牌，有效期为30分钟
     * @param string $verifyCode 短信验证码。验证银行预留手机号
     */
    public function enterpriseChangeCardVerify(string $userId, string $txnSeqno, string $token, string $verifyCode)
    {
        $params = [
            'user_id' => $userId,
            'txn_seqno' => $txnSeqno,
            'token' => $token,
            'verify_code' => $verifyCode
        ];
        return $this->parse($this->url('acctmgr/enterprise-changecard-verify'), $params);
    }

    /**
     * 修改绑定手机申请
     * https://open.lianlianpay.com/docs/accp/accpstandard/change-regphone-apply.html
     */
    public function changeRegPhoneApply(array $params)
    {
        return $this->parse($this->url('acctmgr/change-regphone-apply'), $params);
    }

    /**
     * 修改绑定手机验证
     * https://open.lianlianpay.com/docs/accp/accpstandard/change-regphone-verify.html
     * @param array $params
     */
    public function changeRegPhoneVerify(array $params)
    {
        return $this->parse($this->url('acctmgr/change-regphone-verify'), $params);
    }

    /**
     * 修改预留手机号申请
     * https://open.lianlianpay.com/docs/accp/accpstandard/change-linkedphone-apply.html
     * @param array $params
     */
    public function changeLinkedPhoneApply(array $params)
    {
        return $this->parse($this->url('acctmgr/change-linkedphone-apply'), $params);
    }

    /**
     * 修改预留手机号验证
     * https://open.lianlianpay.com/docs/accp/accpstandard/change-linkedphone-verify.html
     * @param array $params
     */
    public function changeLinkedPhoneVerify(array $params)
    {
        return $this->parse($this->url('acctmgr/change-linkedphone-verify'), $params);
    }

    /**
     * 绑卡信息查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-linkedacct.html
     * @param string $userId 用户在商户系统中的唯一编号，要求该编号在商户系统能唯一标识用户。由商户自定义。
     */
    public function queryLinkedAcct(string $userId)
    {
        $params = [
            'user_id' => $userId
        ];
        return $this->parse($this->url('acctmgr/query-linkedacct'), $params);
    }

    /**
     * 用户信息查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-userinfo.html
     * @param string $userId 用户在商户系统中的唯一编号，要求该编号在商户系统能唯一标识用户。由商户自定义。
     */
    public function queryUserInfo(string $userId)
    {
        $params = [
            'user_id' => $userId
        ];
        return $this->parse($this->url('acctmgr/query-userinfo'), $params);
    }

    /**
     * 账户信息查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-acctinfo.html
     * @param String $userType
     * @param null $userId
     */
    public function queryAcctInfo(String $userType, $userId = null)
    {
        $params = [
            'user_type' => $userType,
            'user_id' => $userId
        ];
        return $this->parse($this->url('acctmgr/query-acctinfo'), $params);
    }

    /**
     * 资金流水列表查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-acctserial.html
     * @param array $params
     */
    public function queryAcctSerial(array $params)
    {
        return $this->parse($this->url('acctmgr/query-acctserial'), $params);
    }

    /**
     * 交易流水结果查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-txn.html
     * @param string $txnSeqno
     */
    public function queryTxn(string $txnSeqno)
    {
        $params = [
            'txn_seqno' => $txnSeqno
        ];
        return $this->parse($this->url('acctmgr/query-txn'), $params);
    }

    /**
     * 资金流水详情查询
     * https://open.lianlianpay.com/docs/accp/accpstandard/query-acctserialdetail.html
     * @param string $userId 用户在商户系统中的唯一编号，要求该编号在商户系统能唯一标识用户。由商户自定义。
     * @param string $userType 用户类型
     * @param string $jnoAcct 资金流水号。ACCP账务系统资金流水唯一标识。
     */
    public function queryAcctSerialDetail(string $userId, string $userType, string $jnoAcct)
    {
        $params = [
            'user_id' => $userId,
            'user_type' => $userType,
            'jno_acct' => $jnoAcct
        ];
        return $this->parse($this->url('acctmgr/query-acctserialdetail'), $params);
    }
}