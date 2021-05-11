<?php


namespace App\Services;


use Library\Mcrypt\Aes;
use Library\Mcrypt\Rsa;

class SslService
{
    protected $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC9Czd0pMrl2iYDTWhIPQLcM4uh6NwFgpjulH4N9pK34k3q8cTa
HwCokxoStG/GE1RjF7UhIpy/rjud3BRkhO36BNYV8abqUERN/SmXHdZfJwnzAPVw
Pt6ijSQZAwXev7FVUNSgmNxBEok/OhdJRxAGXBhIBsN0a03Jn0yt2bZliwIDAQAB
AoGAd60vKU/eBw9Ie1S4zOqa8e5L2m9BQte/m2I0PwC3N2Qz8aWm+nMgBphBrE/A
ZwP7q1Pp3hU8aHiT00btPgmNYWAvikiZrLyzpVl0ZcFmyZ8FOyKimbgWAr3Hvfmb
Q77TpAXvp1nub/d6iO6JcZtLjIfEfGsQ7UjhGSDBxHmMSskCQQDqYRWjZrsWDG8E
YJZMeiZPxAGCF+XoGlaAdQzawdVNCntV8DDWGmBNMZAn9tePOuE9tnyIDI5+3xGe
Z+tlXuzXAkEAznuGx9GElDjh8f5DloXiQqM05QqLYKKA2znLao7f2m2GKLPkmSCn
lCsQVtGH/plTLZd7S8nrRkBXuQ2mGAEibQJBAIz4W8VuMrSuQc/GMGBLT+PGJooS
yatyu/iDbnnc/+hYl5o234jHUIjdeLEw3LI/Xd56dih2NPbGQJigNItCLv0CQQC5
uEuzgNVyCHPaGOwsAIJRk8Co3sIcii3CgYpgbuAT9H0+MQhFXyS71bwditt6eehh
0qWYtqaDCq6ciRVC9ApFAkB/BSXLRjNDpXj07oreXbB4O1tesDOgBZELYzI3Cq8b
GcnpF6GjUsGkIwQvtI1VVBn9l9JMVeB+BESXChWL7zkk
-----END RSA PRIVATE KEY-----';
    protected $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9Czd0pMrl2iYDTWhIPQLcM4uh
6NwFgpjulH4N9pK34k3q8cTaHwCokxoStG/GE1RjF7UhIpy/rjud3BRkhO36BNYV
8abqUERN/SmXHdZfJwnzAPVwPt6ijSQZAwXev7FVUNSgmNxBEok/OhdJRxAGXBhI
BsN0a03Jn0yt2bZliwIDAQAB
-----END PUBLIC KEY-----';

    /**
     * 加密
     * @param string $string
     * @param string $aesKey
     * @return array
     * @throws \Library\Mcrypt\McryptException
     */
    public function encrypt(string $string, $aesKey = "zd0pMrl2iYDTWhIPQLcM4uh")
    {
        $aes = new Aes($aesKey, ""); //对称加密
        $rsa = new Rsa($this->publicKey, $this->privateKey); //非对称加密
        //1. 使用上述密钥对本次请求的参数进行AES128加密，得到请求参数密文，得到密文miwenData
        $stringEncrypt = $aes->setMode("ECB")->setSize(128)->encrypt($string);

        //2. 使用前后端约定的RSA公钥对1中的密钥加密,得到miwenKey
        $aesKeyEncrypt = $rsa->encrypt($aesKey, Rsa::PUBLIC_KEY_ENCODE);

        return [$stringEncrypt, $aesKeyEncrypt];
    }

    public function decrypt($stringEncrypt, $aesKeyEncrypt)
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey); //非对称加密

        //  私钥解密 得到aes密钥
        $aesKey = $rsa->decrypt($aesKeyEncrypt, Rsa::PRIVATE_KEY_DECODE);

        //  aes 解密字符串数据 AES-128-ECB
        $aes = new Aes($aesKey, ""); //对称加密
        $string = $aes->setMode("ECB")->setSize(128)->decrypt($stringEncrypt);

        return [$string, $aesKey];
    }
}