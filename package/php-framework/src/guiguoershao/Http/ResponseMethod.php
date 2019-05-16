<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午4:22
 */

namespace Guiguoershao\Http;


class ResponseMethod
{
    /**
     * @param array $data
     * @return string
     */
    public function json($data = [])
    {
        header('content-type:application/json;charset=utf-8');
        return json_encode((object)$data,JSON_UNESCAPED_UNICODE);
    }

    public function file()
    {
    }

    public function download($fileUrl,$fileName)
    {
        $fileName = $fileName ? $fileName :basename($fileName);
        header("Content-type: application/octet-stream");
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $encoded_filename = rawurldecode($fileName);
        if(preg_match("/MSIE/", $ua)){
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }elseif (preg_match("/Firefox/", $ua)){
            header("Content-Disposition: attachment; filename*=\"utf8''" . $fileName . '"');
        }else{
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
        }
        $file_size = getFileSize($fileUrl);
        header("Content-Length: " . $file_size);
        readfile($fileUrl);
        exit();
    }

    public function header()
    {

    }
}