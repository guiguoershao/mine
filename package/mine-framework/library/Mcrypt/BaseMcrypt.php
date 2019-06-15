<?php


namespace Library\Mcrypt;


abstract class BaseMcrypt
{

    /**
     * 密钥
     * @var
     */
    protected $key;

    /**
     * 偏移量
     * @var
     */
    protected $hexIv = '1234567890asdfgh';

    public function __construct($key, $hexIv = '')
    {
//        $this->key = hash('sha256', $key, true); // key生成新地摘要
        $this->key = $key;
        $this->hexIv = empty($hexIv) ? $this->hexIv : $hexIv;
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