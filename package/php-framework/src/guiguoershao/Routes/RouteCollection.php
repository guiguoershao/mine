<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午4:03
 */

namespace Guiguoershao\Routes;


use Guiguoershao\Container\Content;

class RouteCollection
{

    /**
     * 把字符串切割为数组
     * @param $callFile
     * @return array
     */
    public function breakUpString($callFile)
    {
        $explode = explode('@', $callFile);

        return $explode;
    }

    /**
     * 添加到集合
     * @param $uri
     * @param RouteModel $routeModel
     */
    public function add($uri, RouteModel $routeModel)
    {
        if (empty($_SERVER['routes'][$uri])) {
            $_SERVER['routes'][$uri] = $routeModel;
        }
    }

    public function link($action)
    {
        if (is_string($action)) {
            $actionParams = $this->breakUpString($action);

            return (new Content())->run($actionParams);
        }
    }
}