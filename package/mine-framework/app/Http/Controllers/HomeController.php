<?php


namespace App\Http\Controllers;


use Library;

class HomeController
{

    public function index()
    {
        $mcryptDes = new Library\Mcrypt\Des();
        $data = 'Hello World';
        $method = 'des-cbc';
        $key = '123456';
        $iv_length = openssl_cipher_iv_length( $method );
        $iv        = openssl_random_pseudo_bytes( $iv_length );
        dump($enString = $mcryptDes->encrypt($data, $method, $key, $iv));
        dump($mcryptDes->decrypt($enString, $method, $key, $iv));

    }
}