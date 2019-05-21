<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午3:26
 */

namespace guiguoershao\Route;

use guiguoershao\Http\Http;
use guiguoershao\Reflect\Reflect;
use function GuzzleHttp\Psr7\str;

class RouteCollection
{
    /**
     * 路由列表
     * @var array
     */
    public static $routesArr = [];

    /**
     * 路由调用控制器命名空间前缀
     * @var string
     */
    public static $rootNamespace = 'App\\http\\';

    /**
     * @var array
     */
    public static $groupOffset = [];

    /**
     * @param $method
     * @param $uri
     * @param $action
     * @return bool
     */
    public function add($method, $uri, $action)
    {
        return self::addRoutes($method, $uri, $action);
    }

    /**
     * 添加路由
     * @param $method
     * @param $uri
     * @param $action
     * @return bool
     */
    private static function addRoutes($method, $uri, $action)
    {
        if (!isset(self::$routesArr[$method])) {
            self::$routesArr[$method] = [];
        }

        if ($uri != '/') {
            $uri = trim($uri, '/');
        }

        self::$routesArr[$method][$uri]['url'] = $uri;
        self::$routesArr[$method][$uri]['action'] = $action;

        if (is_array(self::$groupOffset) && !empty(self::$groupOffset)) {
            foreach (self::$groupOffset as $item => $value) {
                if (!isset(self::$routesArr[$method][$uri][$item])) {
                    self::$routesArr[$method][$uri][$item] = [];
                }

                if (is_array($value)) {
                    self::$routesArr[$method][$uri][$item] = array_merge(self::$routesArr[$method][$uri][$item], $value);
                } else {
                    self::$routesArr[$method][$uri][$item] = array_merge(self::$routesArr[$method][$uri][$item], [$value]);
                }
            }
        }
        return true;
    }

    /**
     * 路由分组
     * @param array $group
     * @param \Closure $closure
     */
    public function group(array $group, \Closure $closure)
    {
        if (!empty($group)) {
            self::$groupOffset = $group;
        }
        call_user_func($closure);
        self::$groupOffset = [];
    }

    /**
     * 路由调度
     * @param Http $http
     */
    public function dispatch(Http $http)
    {
        $requestMethod = strtoupper($http->server()->getMethod());

        list($code, $route) = self::_dispatch($requestMethod, $http->server()->getUri());
        switch ($code) {
            case 404:
                $http->noFound();
                break;
            case 405:
                $http->methodIsNotAllow();
                break;
            case 200:
                // 如果存在中间件
                if (!empty($route['middleware'])) {
                    foreach ($route['middleware'] as $item => $value) {
                        //  中间件处理方法
                    }
                }
                if ($route['action'] instanceof \Closure) {
                    $http->callFunction($route['action']);
                } else {
                    $routeArr = explode('@', $route['action']);
                    if (count($routeArr) == 2) {
                        list($controller, $param) = self::parseClass(self::$rootNamespace.$routeArr[0], $routeArr[1], $route['param']);
                        $http->callController($controller, $routeArr[1], $param);
                    } else {
                        $http->noFound();
                    }
                }
                break;
            default:
                $http->noFound();
                break;
        }
    }

    protected static function parseClass($class, $method, $param)
    {
        //  对象实例化参数
        $constructParamArr = [];
        $reflectClass = new \ReflectionClass($class);
        $reflectConstructMethod = $reflectClass->getConstructor();
        $reflect = new Reflect();
        if ($reflectConstructMethod) {
            $constructParamArr = $reflect->reflectParam($reflectClass, $reflectConstructMethod->getName(), $param);
        }

        return [$reflectClass->newInstanceArgs($constructParamArr), $reflect->reflectParam($reflectClass, $method, $param)];
    }

    /**
     * 调度
     * @param $requestMethod
     * @param $uri
     * @return array
     */
    private static function _dispatch($requestMethod, $uri)
    {
        list($uri) = explode('?', $uri);

        if (empty(self::$routesArr) && !isset(self::$routesArr[$requestMethod])) {
            return [405, null];
        }
        $any = isset(self::$routesArr['ANY']) ? self::$routesArr['ANY'] : [];

        $routeMethodArr = isset(self::$routesArr[$requestMethod]) ? self::$routesArr[$requestMethod] : [];

        $route = self::parsePath($routeMethodArr + $any, $uri);

        if (empty($route)) {
            return [404, null];
        }

        return [200, $route];
    }

    /**
     * 解析路由
     * @param $mapUriArr
     * @param $uri
     * @return array
     */
    private static function parsePath($mapUriArr, $uri)
    {
        $route = null;
        $uri = str_replace('index.php', '', $uri);
        $uri = ($uri != '/') ? trim($uri, '/') : $uri;
        if (isset($mapUriArr[$uri])) {
            $route = $mapUriArr[$uri];
            $route['param'] = [];
        } else {
            $uriArr = explode('/', $uri);
            $uriLen = count($uriArr);
            foreach ($mapUriArr as $item => $value) {
                $expUriArr = explode('/', $item);
                if (count($expUriArr) == $uriLen && !empty($expUriArr[0]) && preg_match('/\{[^S]+\}/si', $item)) {
                    $flag = true;
                    $param = [];
                    foreach ($expUriArr as $k => $v) {
                        $v = ltrim($v, "{");
                        $v = rtrim($v, "}");
                        $expArr = explode(':', $v);
                        if (count($expArr) == 2) {
                            $regex = $expArr[1];
                        } else {
                            $regex = "/^[\\w_]+$/si";
                        }
                        if (preg_match($regex, $uriArr[$k], $matches)) {
                            $param[$expArr[0]] = $uriArr[$k];
                        } else {
                            $flag = false;
                            break;
                        }
                    }
                    if ($flag) {
                        $route = $value;
                        $route['param'] = $param;
                        break;
                    }
                }
            }
        }
        return $route;
    }
}