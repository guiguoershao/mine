<?php

namespace WebSocket\Base;
/**
 * Class Util
 * @package websocket\Base
 */
class Util
{
    /**
     * @param $tag
     * @param $msg
     */
    public static function ps($tag, $msg)
    {
        $date = date('Y-m-d H:i:s');
        echo "date:{$date},tag:$tag,msg:$msg\r\n";
    }

    /**
     * 获取随机字符串
     * @param int $len 字符串长度
     * @param int $mode 类型
     * @param int $letterNum 字母个数
     * @return bool|string
     */
    public static function getRandString($len = 32, $mode = 0, $letterNum = 0)
    {
        static $chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $str = '';
        switch ($mode) {
            //数字字母混排
            case 0:
                while ($len-- > 0) {
                    $str .= $chars[mt_rand(0, 61)];
                }
                break;
            case 1:
                //纯数字
                while ($len-- > 0) {
                    $str .= $chars[mt_rand(52, 61)];
                }
                break;
            case 2:
                //纯字母
                while ($len-- > 0) {
                    $str .= $chars[mt_rand(0, 51)];
                }
                break;
            case 3:
                //  只包含指定个数的字母
                for ($i = 1; $i <= $len; $i++) {
                    if ($i <= $letterNum) {
                        $str .= $chars[mt_rand(0, 51)];
                    } else {
                        $str .= $chars[mt_rand(52, 61)];
                    }
                }
                $str = str_shuffle($str);
                break;
            default:
                return false;
                break;
        }

        return $str;
    }
}