<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 上午11:07
 */

namespace guiguoershao\Sys\Providers;


use guiguoershao\Sys\Configs\Config;
use guiguoershao\Sys\ServiceProvider;

class ConfigProvider extends ServiceProvider
{

    /**
     * 注册容器
     * @return mixed
     */
    public function register()
    {
        app()->register('config', function () {
            return Config::getInstance();
        });
    }

    /**
     * 驱动容器
     * @return mixed
     */
    public function boot()
    {
        Config::getInstance()->load(__CONFIG__);
    }
}