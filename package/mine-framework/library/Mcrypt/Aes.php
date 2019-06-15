<?php


namespace Library\Mcrypt;


class Aes extends BaseMcrypt
{

    /**
     * @var int
     */
    protected $size = 256;


    /**
     * @var string
     */
    protected $mode = 'CBC';

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function encrypt($input)
    {
        $method = $this->getOpenSslName();
        $this->isOpenssl()->isHasMethod($method);
        $data = openssl_encrypt($input, $method, $this->key, OPENSSL_RAW_DATA, $this->getHexIv());
        return base64_encode($data);
    }

    public function decrypt($input)
    {
        $method = $this->getOpenSslName();
        $this->isOpenssl()->isHasMethod($method);
        $decrypted = openssl_decrypt(base64_decode($input), $method, $this->key, OPENSSL_RAW_DATA, $this->getHexIv());
        return $decrypted;
    }

    /**
     * 加密方法
     * @return string
     */
    public function getOpenSslName()
    {
        return "AES-{$this->size}-{$this->mode}";
    }

    protected function getHexIv()
    {
        $byte = $this->size / 8;
        $byte = 16;
        $ivLen = strlen($this->hexIv);
        if ($byte > $ivLen) {
            $str = $this->hexIv. str_repeat('0', $byte - $ivLen);
        } else {
            $str = substr($this->hexIv, 0, $byte);
        }
        dump($str);
        return $str;
    }
}