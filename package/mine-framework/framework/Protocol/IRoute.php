<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午3:08
 */

namespace guiguoershao\Protocol;


interface IRoute
{
    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function get($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function post($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function patch($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function put($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function delete($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function options($uri, $action = null);

    /**
     * @param $uri
     * @param null $action
     * @return mixed
     */
    public static function any($uri, $action = null);
}