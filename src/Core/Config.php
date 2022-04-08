<?php
/*
 * @Author: Y95201 
 * @Date: 2022-03-31 13:01:34 
 * @Last Modified by: Y95201
 * @Last Modified time: 2022-03-31 14:01:41
 */
namespace Y95201\Core;
class Config  extends Collection
{
    /**
     * 获取商户私钥
     */
    public function getInstantPayPrivateKey(): string
    {
        if (file_exists($this->get('private_key'))) {
            return file_get_contents($this->get('private_key'));
        } else {
            return $this->get('private_key');
        }
    }
    /**
     * 获取商户公钥
     */
    public function getInstantPayPublicKey(): string
    {
        if (file_exists($this->get('public_key'))) {
            return file_get_contents($this->get('public_key'));
        } else {
            return $this->get('public_key');
        }
    }
    /**
     * 获取连连公钥
     */
    public function getInstantPayLianLianPublicKey(): string
    {
        if (file_exists($this->get('ll_public_key'))) {
            return file_get_contents($this->get('ll_public_key'));
        } else {
            return $this->get('ll_public_key');
        }
    }
}