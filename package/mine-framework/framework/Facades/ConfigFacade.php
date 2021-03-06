<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 下午2:24
 */

namespace guiguoershao\Facades;
use guiguoershao\Sys\Configs\Config;

class ConfigFacade extends Facade
{

    /**
     * @return string
     */
    static public function getFacadeAccessor(): string
    {
        return Config::class;
    }
}