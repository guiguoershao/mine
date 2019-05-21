<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-21
 * Time: 上午10:19
 */

namespace App\Providers;


use guiguoershao\Sys\ServiceProvider;

class AppProvider extends ServiceProvider
{

    /**
     * 注册容器
     * @return mixed
     */
    public function register()
    {
        $app = app();
    }

    /**
     * 驱动容器
     * @return mixed
     */
    public function boot()
    {
    }
}