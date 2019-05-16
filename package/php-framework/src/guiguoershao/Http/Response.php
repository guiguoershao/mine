<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午4:21
 */

namespace Guiguoershao\Http;


class Response
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function end()
    {
        if (isset($this->response)) {
            echo $this->response;
        }
    }
}