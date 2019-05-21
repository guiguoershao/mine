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

    private static $instance;

    /**
     * @var RouteCollection
     */
    private static $routes;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        if (!self::$routes instanceof RouteCollection) {
            self::$routes = new RouteCollection();
        }
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function get($uri, $action = null)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function post($uri, $action = null)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function patch($uri, $action = null)
    {
        $this->addRoute('PATCH', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function put($uri, $action = null)
    {
        $this->addRoute('PUT', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function delete($uri, $action = null)
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function options($uri, $action = null)
    {
        $this->addRoute('OPTIONS', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public function any($uri, $action = null)
    {
        $this->addRoute('ANY', $uri, $action);
    }

    public function addRoute($method, $uri, $action)
    {
        if (self::verify($method) == false) {
            return false;
        }

        self::$routes->add($method, $uri, $action);
    }

    /**
     * @param $rootNamespace
     * @return $this
     */
    public static function setRootNamespace($rootNamespace)
    {
        RouteCollection::$rootNamespace = $rootNamespace;
    }

    /**
     *
     * @param array $group
     * @param \Closure $closure
     */
    public function group(array $group, \Closure $closure)
    {
        self::$routes->group($group, $closure);
    }

    /**
     * 路由调度
     * @param Http $http
     */
    public function dispatch(Http $http)
    {
        self::$routes->dispatch($http);
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