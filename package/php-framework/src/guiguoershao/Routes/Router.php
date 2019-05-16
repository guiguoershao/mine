<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午4:00
 */

namespace Guiguoershao\Routes;


class Router implements RouteInterface
{
    /**
     * @var array
     */
    private static $requestMethod = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * 路由集合
     * @var
     */
    public $routes;

    public function __construct()
    {
        $this->routes = '';
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function get($uri, $action = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function post($uri, $action = null)
    {
        // TODO: Implement post() method.
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function patch($uri, $action = null)
    {
        // TODO: Implement patch() method.
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function put($uri, $action = null)
    {
        // TODO: Implement put() method.
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function delete($uri, $action = null)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function options($uri, $action = null)
    {
        // TODO: Implement options() method.
    }
}