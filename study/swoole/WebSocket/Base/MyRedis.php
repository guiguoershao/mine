<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-10-15
 * Time: 下午3:46
 */

namespace WebSocket\Base;

class MyRedis
{
    private static $instance;

    private $redis;

    public function __construct()
    {
        $config = Config::getInstance()->getRedisConfig();

        $this->redis = new \Predis\Client(
            [
                'scheme' => 'tcp',
                'host'   => $config['host'],
                'port'   => $config['port'],
                'database' => $config['db']
            ]
        );
    }

    /**
     * @param $instance
     * @return MyRedis
     */
    public static function getInstance($instance)
    {
        if (!(self::$instance instanceof self) || $instance === true) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    /**
     * @param $key
     * @return string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * @param string|array $keys
     * @return int
     */
    public function del($keys)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }
        return $this->redis->del($keys);
    }

    /**
     * @param $key
     * @param string|array $members
     * @return int
     */
    public function sAdd($key, $members)
    {
        if (!is_array($members)) {
            $members = [$members];
        }
        return $this->redis->sadd($key, $members);
    }

    /**
     * @param $key
     * @param $member
     * @return int
     */
    public function sRemove($key, $member)
    {
        return $this->redis->srem($key, $member);
    }

    /**
     * @param $key
     * @return array
     */
    public function sMembers($key)
    {
        return $this->redis->smembers($key);
    }

    /**
     * @param $key
     * @param $member
     * @return int
     */
    public function sIsMember($key, $member)
    {
        return $this->redis->sismember($key, $member);
    }
}