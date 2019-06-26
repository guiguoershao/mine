<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 下午3:37
 */

namespace App\Services\Queues;


use App\Services\MyRedisLock;

class MyMsgQueue
{
    public $errCode = 0;
    public $errMsg = "";
    public $redis;
    public $prefix = "queue:";
    public $timeOut = 10;
    public $lockRedis;

    /**
     * MyMsgQueue constructor.
     * @param \Predis\Client $redis
     */
    public function __construct(\Predis\Client $redis)
    {
        $this->redis = $redis;

        $this->lockRedis = MyRedisLock::getInstance($redis);
    }

    /**
     *
     */
    public function __destruct()
    {
        if ($this->redis) {
            $this->redis->quit();
        }
    }

    /**
     * 加入队列表尾最右侧
     * @param $pubKey
     * @param string $data
     * @return bool
     */
    public function publish($pubKey, string $data)
    {
        $this->ping();
        $res = $this->redis->rpush($this->getQueueKey($pubKey), [$data]);
        if ($res === false) {
            return false;
        }
        return true;
    }

    /**
     * 获取队列长度
     * @param $pubKey
     * @param $len
     * @return bool
     */
    public function getLisLength($pubKey, &$len)
    {
        $this->ping();
        $len = 0;
        $res = $this->redis->llen($this->getQueueKey($pubKey));
        if ($res === false) {
            return false;
        }
        $len = $res;
        return true;
    }

    /**
     *
     * @param $pubKey
     * @param $data
     * @return bool
     */
    public function subscribe($pubKey, &$data = null)
    {
        $this->ping();

        $lockId = $this->lockRedis->lock($this->getQueueKey($pubKey));
        $res = $this->redis->lpop($this->getQueueKey($pubKey));
        $this->lockRedis->releaseLock($this->getQueueKey($pubKey), $lockId);

        if ($res === false) {
            return false;
        }
        $data = $res;
        return true;
    }

    /**
     * 阻塞模式
     * @param $pubKey
     * @param $data
     * @return bool
     */
    public function blockSubscribe($pubKey, &$data)
    {
        $this->ping();
        $res = $this->redis->blpop([$pubKey], 5); // 阻塞5秒
        if ($res === false) {
            return false;
        }
        $data = $res[1];
        return true;
    }

    /**
     * @param $pubKey
     * @return string
     */
    private function getQueueKey($pubKey)
    {
        return $this->prefix . $pubKey;
    }

    private function ping()
    {
        if ($this->redis->ping()) {
            return true;
        }
        throw new \Exception("Redis Ping Error");
    }
}