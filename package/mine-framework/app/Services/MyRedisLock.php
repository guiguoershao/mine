<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 下午5:38
 */

namespace App\Services;


class MyRedisLock
{
    private static $instance = null;

    private $lockPrefix = 'common_base_lock';

    public function __construct()
    {

    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getRedis() : \Predis\Client
    {
        return \MyRedis::getInstance();
    }

    public function lock($key, $wait = 1, $expire = 5)
    {
        $this->getRedis();
    }
}