<?php


namespace App\Http\Controllers;


use App\Services\SslService;

class SslController
{
    public function test()
    {
        $ssl = new SslService();

        $string = "Hello World!";
        $aeskey = "123456789";
        list($stringEncrypt, $aesKeyEncrypt) = $ssl->encrypt($string, $aeskey);
        dump($stringEncrypt, $aesKeyEncrypt);
        list($string, $aesKey) = $ssl->decrypt($stringEncrypt, $aesKeyEncrypt);
        dump($string, $aesKey);
    }
}