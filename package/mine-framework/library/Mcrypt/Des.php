<?php


namespace Library\Mcrypt;


class Des extends BaseMcrypt
{

    /**
     * @param $string
     * @param $method
     * @param $key
     * @param $iv
     * @return string
     * @throws McryptException
     */
    public function encrypt(string $string, $method, $key, $iv)
    {
        $this->isOpenssl()->isHasMethod($method);
        return openssl_encrypt($string, $method, $key, 0, $iv);
    }

    public function decrypt(string $enString, $method, $key, $iv)
    {
        $this->isOpenssl()->isHasMethod($method);
        return openssl_decrypt( $enString, $method, $key, 0, $iv );
    }
}