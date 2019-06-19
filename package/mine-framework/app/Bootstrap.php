<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-21
 * Time: 上午9:32
 */

namespace App;


use guiguoershao\Container\Container;
use guiguoershao\Http\Http;
use guiguoershao\Protocol\IBootstrap;
use guiguoershao\Sys\Configs\Config;

class Bootstrap implements IBootstrap
{

    /**
     * 启动初始化
     * @param Container $container
     * @return Container
     */
    public function boot(Container $container)
    {
        $container->register(Http::class, function () {
            return new Http();
        })->resolverProviders([
            'app' => \guiguoershao\Sys\Providers\AppProvider::class,
            'route' => \guiguoershao\Sys\Providers\RouteProvider::class,
            'config' => \guiguoershao\Sys\Providers\ConfigProvider::class,
        ])->resolverProviders(Config::getInstance()->get('app.providers', []));

        return $container;
    }
}