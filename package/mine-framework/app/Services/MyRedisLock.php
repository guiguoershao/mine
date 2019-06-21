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
    protected static $instance = null;

    const LOCK_KEY_PREFIX = 'lock:base:';

    const LOCK_UNIQUE_ID_KEY = 'lock:unique_id';

    const LOCK_DEFAULT_EXPIRE_TIME = 100; // 默认锁的失效时间 单位秒

    protected static $redis;

    public function __construct(\Predis\Client $redis)
    {
        self::$redis = $redis;
    }

    public static function getInstance(\Predis\Client $redis)
    {
        if (self::$instance == null) {
            self::$instance = new self($redis);
        }
        return self::$instance;
    }

    private function getRedis():\Predis\Client
    {
        return self::$redis;
    }

    /**
     * 创建锁
     * @param string $key 加锁的key
     * @param int $waitLockTime 等待锁建立的时间,
     * @param int $intExpireTime 给锁设置定时失效时间
     * @return bool|mixed
     */
    public function lock($key, $waitLockTime = 1, $intExpireTime = self::LOCK_DEFAULT_EXPIRE_TIME)
    {
        $hasWait = 0; // 已经等待的时间 毫秒
        $this->getRedis();
        $uniqueLockId = $this->generateUniqueLockId();
        do {
//            $getLock = $this->getRedis()->set($this->_getKeyName($key), $uniqueLockId, ['nx', 'ex'=> $intExpireTime]);
            $getLock = $this->getRedis()->set($this->_getKeyName($key), $uniqueLockId, 'EX', $intExpireTime, 'NX');
            if ($getLock) {
                return $uniqueLockId;
            }
            //  已等待时间超过规定等待时间则返回 获取锁失败
            if ($hasWait > $waitLockTime * 1000) {
                return false;
            }
            usleep(100000); // 等待100毫秒
            $hasWait += 100; // 每次循环 已等待时间增加100毫秒
        } while (true);

        return false;
    }

    /**
     * 解锁
     * WATCH命令可以监控一个或多个键，一旦其中有一个键被修改（或删除），之后的事务就不会执行。监控一直持续到EXEC命令（事务中的命令是在EXEC之后才执行的，所以在MULTI命令后可以修改WATCH监控的键值）
     * @param $key
     * @param $uniqueLockId
     * @return bool
     */
    public function releaseLock($key, $uniqueLockId)
    {
        if (empty($key) || empty($uniqueLockId)) {
            return false;
        }
        $strKey = $this->_getKeyName($key);

        //  监听Redis key防止在【比对lock id】与【解锁事务执行过程中】被修改或删除，提交事务后会自动取消监控，其他情况需手动解除监控
        $this->getRedis()->watch($strKey);
        if ($uniqueLockId == $this->getRedis()->get($strKey)) {
            $this->getRedis()->multi();
            $this->getRedis()->del([$strKey]);
            $this->getRedis()->exec();
            return true;
        }
        $this->getRedis()->unwatch();
        return false;
    }

    /**
     * lock key name
     * @param $uniqueKey
     * @return string
     */
    protected function _getKeyName($uniqueKey)
    {
        return self::LOCK_KEY_PREFIX . $uniqueKey;
    }

    /**
     * 生成锁唯一ID（通过Redis incr指令实现简易版本，可结合日期、时间戳、取余、字符串填充、随机数等函数，生成指定位数唯一ID）
     * @return mixed
     */
    protected function generateUniqueLockId()
    {
        if (!$this->getRedis()->exists(self::LOCK_UNIQUE_ID_KEY)) {
            $id = $this->getRedis()->incr(self::LOCK_UNIQUE_ID_KEY);
            $this->getRedis()->expire(self::LOCK_UNIQUE_ID_KEY, strtotime(date('Y-m-d')) + 86400);
        } else {
            $id = $this->getRedis()->incr(self::LOCK_UNIQUE_ID_KEY);
        }
        return date('YmdHis') . ':' . $id;
    }
}