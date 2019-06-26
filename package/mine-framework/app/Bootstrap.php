<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-21
 * Time: 上午9:32
 */

namespace App;


use guiguoershao\Container\Container;
use guiguoershao\Facades\ConfigFacade;
use guiguoershao\Http\Http;
use guiguoershao\Protocol\IBootstrap;

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
            \guiguoershao\Sys\Providers\AppProvider::class,
            \guiguoershao\Sys\Providers\RouteProvider::class,
            \guiguoershao\Sys\Providers\ConfigProvider::class,
        ])->aliasClass(ConfigFacade::get('app.aliases'))
            ->resolverProviders(ConfigFacade::get('app.providers'));
        return $container;
    }
}