<?php


namespace App\Http\Controllers;


use Library;

class HomeController
{

    public function index()
    {
        dump('------------------DES加密--------------------------------------');
        $key = '123456';
        $data = 'Hello World';
        $method = 'des-ede3-cbc'; // 3des
        $method = 'des-cbc';
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $des = new Library\Mcrypt\Des($key, $iv);
        dump($enString = $des->setMethod($method)->encrypt($data));
        dump($des->decrypt($enString));

        dump('------------------AES加密--------------------------------------');
        $method = 'AES-256-CBC';
        $iv = '';
        $aes = new Library\Mcrypt\Aes($key);
        dump($enString = $aes->setSize(128)->encrypt($data, $method));
        dump($aes->decrypt($enString, $method));
        dump('------------------RSA加密--------------------------------------');

        $privateKey = '-----BEGIN RSA PRIVATE KEY-----
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
        $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9Czd0pMrl2iYDTWhIPQLcM4uh
6NwFgpjulH4N9pK34k3q8cTaHwCokxoStG/GE1RjF7UhIpy/rjud3BRkhO36BNYV
8abqUERN/SmXHdZfJwnzAPVwPt6ijSQZAwXev7FVUNSgmNxBEok/OhdJRxAGXBhI
BsN0a03Jn0yt2bZliwIDAQAB
-----END PUBLIC KEY-----';
        $rsa = new Library\Mcrypt\Rsa($publicKey, $privateKey);
        dump($data);
        dump($enString = $rsa->encrypt($data, Library\Mcrypt\Rsa::PRIVATE_KEY_ENCODE));
        dump($rsa->decrypt($enString, Library\Mcrypt\Rsa::PUBLIC_KEY_DECODE));


        dump($data);
        dump($enString = $rsa->encrypt($data, Library\Mcrypt\Rsa::PUBLIC_KEY_ENCODE));
        dump($rsa->decrypt($enString, Library\Mcrypt\Rsa::PRIVATE_KEY_DECODE));
    }
}