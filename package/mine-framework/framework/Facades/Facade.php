<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 下午12:54
 */

namespace guiguoershao\Facades;


use guiguoershao\Exception\MiniException;
use guiguoershao\Sys\Configs\Config;

abstract class Facade
{
    /**
     *
     * @return mixed|null
     */
    final public static function getFacadeRoot()
    {
        $facadeAccessor = static::getFacadeAccessor();
        $obj = app()->make($facadeAccessor);
        return $obj;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws MiniException
     */
    final public static function __callStatic($name, $arguments)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new MiniException("A facade root has not been set");
        }

        return $instance->$name(...$arguments);
    }

    /**
     * @return mixed
     */
    abstract static public function getFacadeAccessor() : string ;
}