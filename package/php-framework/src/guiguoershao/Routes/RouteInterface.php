<?php
/**
 * 路由方法接口
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午3:56
 */
namespace Guiguoershao\Routes;


interface RouteInterface
{
    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function get($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function post($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function patch($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function put($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function delete($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function options($uri, $action = null);
}