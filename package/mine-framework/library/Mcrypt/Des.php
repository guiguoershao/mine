<?php


namespace Library\Mcrypt;


class Des extends BaseMcrypt
{

    protected $method = '';

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    /**
     * @param $string
     * @param $method
     * @return string
     * @throws McryptException
     */
    public function encrypt($input)
    {
        $this->isOpenssl()->isHasMethod($this->method);
        return openssl_encrypt($input, $this->method, $this->key, 0, $this->hexIv);
    }

    public function decrypt($input)
    {
        $this->isOpenssl()->isHasMethod($this->method);
        return openssl_decrypt( $input, $this->method, $this->key, 0, $this->hexIv );
    }
}