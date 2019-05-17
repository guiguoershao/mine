<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午3:08
 */

namespace guiguoershao\Route;


use guiguoershao\Http\Http;
use guiguoershao\Protocol\IRoute;

class Route implements IRoute
{
    /**
     * @var array
     */
    private static $requestMethod = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'ANY'];

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->routes = new RouteCollection();
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

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function any($uri, $action = null)
    {
        // TODO: Implement any() method.
    }

    public function addRoute($method, $uri, $action)
    {
        if (self::verify($method) == false) {
            return false;
        }

        $this->routes->add($method, $uri, $action);
    }

    /**
     *
     * @param array $group
     * @param \Closure $closure
     */
    public function group(array $group, \Closure $closure)
    {
        $this->routes->group($group, $closure);
    }

    /**
     * 路由调度
     * @param Http $http
     */
    public function dispatch(Http $http)
    {
        $this->routes->dispatch($http);
    }

    /**
     * 验证
     * @param $method
     * @return bool
     */
    private static function verify($method)
    {
        return in_array($method, static::$requestMethod);
    }
}