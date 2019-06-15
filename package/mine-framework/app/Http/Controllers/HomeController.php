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
        $iv_length = openssl_cipher_iv_length( $method );
        $iv        = openssl_random_pseudo_bytes( $iv_length );
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
MIICXAIBAAKBgQCImMIVhEYE9ureo3nusmW3fHknQOKSM7GghXoQdLbfkmOoKgmx
VyCLL3kD91LdVkL8Jhpf8507FN0Ljf8Pt/2CDrL2tqT29PJvcYtYsyvPifsmyd1v
6gTkyRNkXjfh44EBh8PJa0TVRJb1NV4cQ4xm7Ypp1KV9hHoniLqrggBSywIDAQAB
AoGAMx+9UFFL5ZLGsCJOQhTZ9hUrwRHLWv3nBtW+LEeKpF3FV8y4CPw7jWxsphvc
k0O0WWwnZe8nU1QJMUhphKgPxJqRdAcUe1Sva3nlNSOzfqvcMvYBwNzOWCDHE4Ci
+vbR14ipJNwqidB3UPyZMfMNqhaVMFmr7ugjYQP1zPX4ciECQQCNLfDD34WO8tko
rLlYxwDM2RZK1bvKeaSidFAnX2GlPoSqFpF5lr+djfid3wKa8B7kO1M1fgkh/91d
pF0a7hTrAkEA97Csn9G1Ca/pGQEdqSITZNK3C43+6w9ltjbqmFogHI+qHA5GlBgM
zU+TpSFce62+937ecQ/khG+p1YR1HYDBoQJAJjaYI7x9vyqWgv71kEUVP11HPmxJ
z01Ltbk79NxJZtvcNtmy+LFIHlJOSBUT9HIoOmigZis+N5i1B2K03NQyjwJBANKw
mzZbSNbTpsEZPOS40qxpvUB76cKDV26W6hjsWPJSlk3FKu4gQwuFzD6j0Sp3UcDv
T0H3Vdf9sAaq5IBTHOECQHGWv5tVpp/bwFb+z6IinBuaMxRDBjpHOznqbueLyDaP
Vx+GZ0QqD0JbgDMGJu01L2zA6jSZXh4O1D+ECwCtKIE=
-----END RSA PRIVATE KEY-----';
        $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCImMIVhEYE9ureo3nusmW3fHkn
QOKSM7GghXoQdLbfkmOoKgmxVyCLL3kD91LdVkL8Jhpf8507FN0Ljf8Pt/2CDrL2
tqT29PJvcYtYsyvPifsmyd1v6gTkyRNkXjfh44EBh8PJa0TVRJb1NV4cQ4xm7Ypp
1KV9hHoniLqrggBSywIDAQAB
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