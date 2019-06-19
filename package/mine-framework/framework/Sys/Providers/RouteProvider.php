<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-21
 * Time: 上午10:57
 */

namespace guiguoershao\Sys\Providers;


use guiguoershao\Route\Route;
use guiguoershao\Sys\ServiceProvider;

class RouteProvider extends ServiceProvider
{

    /**
     * 注册容器
     * @return mixed
     */
    public function register()
    {
        app()->register(Route::class, function () {
            if (PHP_SAPI == 'cli') {
                $rootNamespace = "App\\Cli\\";
                Route::setRootNamespace($rootNamespace);
                $param = $_SERVER['argv'];
                if (count($param) == 3) {
                    $_SERVER['REQUEST_URI'] = '/' . trim($param[2], '/');
                }
                scan_require_file(__ROOT__ . '/routes', '', false, ['cli']);
            } else {
                $rootNamespace = "App\\Http\\Controllers\\";
                Route::setRootNamespace($rootNamespace);
                scan_require_file(__ROOT__ . '/routes', '', true, ['cli']);
            }
            /*$rootNamespace = "App\\Http\\Controllers\\";
            Route::setRootNamespace($rootNamespace);
            scan_require_file(__ROOT__ . '/routes', '', true, ['cli']);*/
            return new Route();
        });
    }

    /**
     * 驱动容器
     * @return mixed
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}