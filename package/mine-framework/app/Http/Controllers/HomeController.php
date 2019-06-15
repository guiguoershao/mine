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
    }
}