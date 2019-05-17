<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午3:26
 */

namespace guiguoershao\Route;

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
        if (!self::$routesArr[$method]) {
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
}