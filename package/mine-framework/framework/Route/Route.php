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

class Route
{
    /**
     * @var array
     */
    private static $requestMethod = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'ANY'];

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
    }

    /**
     * @return RouteCollection
     */
    private static function routeCollection() : RouteCollection
    {
        if (!self::$routes instanceof RouteCollection) {
            self::$routes = new RouteCollection();
        }
        return self::$routes;
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function get($uri, $action = null)
    {
        self::addRoute('GET', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function post($uri, $action = null)
    {
        self::addRoute('POST', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function patch($uri, $action = null)
    {
        self::addRoute('PATCH', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function put($uri, $action = null)
    {
        self::addRoute('PUT', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function delete($uri, $action = null)
    {
        self::addRoute('DELETE', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function options($uri, $action = null)
    {
        self::addRoute('OPTIONS', $uri, $action);
    }

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function any($uri, $action = null)
    {
        self::addRoute('ANY', $uri, $action);
    }

    /**
     * @param $method
     * @param $uri
     * @param $action
     * @return bool
     */
    public static function addRoute($method, $uri, $action)
    {
        if (self::verify($method) == false) {
            return false;
        }

        self::routeCollection()->add($method, $uri, $action);
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
    public static function group(array $group, \Closure $closure)
    {
        self::routeCollection()->group($group, $closure);
    }

    /**
     * 路由调度
     * @param Http $http
     */
    public function dispatch(Http $http)
    {
        self::routeCollection()->dispatch($http);
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