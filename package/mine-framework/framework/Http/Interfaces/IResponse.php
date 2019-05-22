<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-22
 * Time: 上午11:00
 */

namespace guiguoershao\http\interfaces;


Interface IResponse
{
    
    /**
     * 发送消息
     * @return mixed
     */
    public function send();
}