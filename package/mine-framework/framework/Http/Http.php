<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:27
 */

namespace guiguoershao\Http;
use guiguoershao\Exception\MiniException;

class Http extends Request
{
    /**
     * @param $class
     * @param $action
     * @param array $params
     * @return mixed
     */
    public function callController($class, $action, $params = array())
    {
        call_user_func_array(array($class, $action), $params);
    }

    /**
     * @param $function
     */
    public function callFunction($function)
    {
        call_user_func($function);
    }

    /**
     * 未找到指定匹配路由
     * @throws MiniException
     */
    public function noFound()
    {
        throw new MiniException("path " . $this->server()->getUri() . " is not found", 404);
    }

    /**
     * 未找到指定方法
     * @throws MiniException
     */
    public function methodIsNotAllow()
    {
        throw new MiniException($this->server()->getMethod() . " Method Is Not Allow", 405);
    }
}