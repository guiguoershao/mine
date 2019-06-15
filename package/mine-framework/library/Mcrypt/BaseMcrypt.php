<?php


namespace Library\Mcrypt;


abstract class BaseMcrypt
{

    public function __construct()
    {
    }

    /**
     * @param $method
     * @return $this
     * @throws McryptException
     */
    protected function isHasMethod($method)
    {
        if (!in_array($method, openssl_get_cipher_methods())) {
            throw new McryptException("该{$method}加密方法不存在");
        }

        return $this;
    }

    /**
     * 判断是否开启openssl扩展
     * @throws McryptException
     */
    protected function isOpenssl()
    {
        if (!extension_loaded('openssl')) {
            throw new McryptException("请先开启Openssl扩展");
        }
        return $this;
    }
//    abstract function encrypt();
}