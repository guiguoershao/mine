<?php


namespace App\Http\Controllers;


use App\Services\SslService;

class SslController
{
    public function test()
    {
        /*setcookie('a', 'value');
        dump($_COOKIE['a']);
        $ssl = new SslService();
        $string = "Hello World!";
        $aeskey = "123456789";
        list($stringEncrypt, $aesKeyEncrypt) = $ssl->encrypt($string, $aeskey);
        dump($stringEncrypt, $aesKeyEncrypt);
        list($string, $aesKey) = $ssl->decrypt($stringEncrypt, $aesKeyEncrypt);
        dump($string, $aesKey);*/

        $filename = "ad_contents.sql";//需要读取的文件
        $tag = "\r\n";//行分隔符 注意这里必须用双引号
        $data = $this->readBigFile($filename, $tag);
        echo $data;
    }

    protected function readBigFile($filename, $tag = "\r\n")
    {
        $content = "";//最终内容
        $current = "";//当前读取内容寄存
        $step = 1;//每次走多少字符
        $tagLen = strlen($tag);
        $start = 0;//起始位置
        $i = 0;//计数器
        $handle = fopen($filename, 'r+');//读写模式打开文件，指针指向文件起始位置
        while (feof($handle)) {
            fseek($handle, $start, SEEK_SET);//指针设置在文件开头
            $current = fread($handle, $step);//读取文件
            $content .= $current;//组合字符串
            $start += $step;//依据步长向前移动
            //依据分隔符的长度截取字符串最后免得几个字符
            $substrTag = substr($content, -$tagLen);
            if ($substrTag == $tag) { //判断是否为判断是否是换行或其他分隔符
                $i++;
                $content .= PHP_EOL;
            }
        }
//关闭文件
        fclose($handle);
//返回结果
        return $content;
    }
}