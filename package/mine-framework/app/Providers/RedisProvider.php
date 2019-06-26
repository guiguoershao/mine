<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 上午9:41
 */

namespace App\Providers;


use guiguoershao\Sys\ServiceProvider;

class RedisProvider extends ServiceProvider
{

    /**
     * 注册容器
     * @return mixed
     */
    public function register()
    {
        if (\Config::get('redis.client') == 'predis') {
            app()->register('MyRedis', function () {
                $redis = new \Predis\Client([
                    'scheme' => 'tcp',
                    'host'   => \Config::get('redis.default.host'),
                    'port'   => \Config::get('redis.default.port'),
                ]);
                if (\Config::get('redis.default.password')) {
                    $redis->auth(\Config::get('redis.default.password'));
                }
                $redis->select(\Config::get('redis.default.database'));
                return $redis;
            });
        }
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