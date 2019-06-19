<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 下午4:40
 */

namespace App\Facades;


use guiguoershao\Facades\Facade;

class RedisFacade extends Facade
{

    /**
     * @return mixed
     */
    public static function getFacadeAccessor(): string
    {
        return 'MyRedis';
    }
}