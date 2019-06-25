<?php
/**
 *
 */

namespace App\Services\Queues;


use App\Services\Jobs\MyJob;

class MyRedisQueue
{

    private $redis;

    private static $channelCallbacks = [];

    private static $static = 0;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * 设置每个通道对应的回调方法
     * @param string|array $channel
     * @param callable $callback
     * @return $this
     */
    public function setChannelCallback($channel, $callback = null)
    {
        if (is_array($channel)) {
            foreach ($channel as $key => $value) {
                $this->setChannelCallback($key, $value);
            }
        }

        if (is_string($channel) && is_callable($callback)) {
            self::$channelCallbacks[$channel] = $callback;
        }

        return $this;
    }

    /**
     * 发布
     * @param $channel
     * @param string $message
     * @return $this
     */
    public function publish($channel, string $message)
    {
        $this->redis->publish($channel, $message);
        return $this;
    }

    /**
     * 订阅
     * @param array $channels
     * @return bool
     */
    public function subscribe(array $channels)
    {
        $this->redis->subscribe($channels, function ($redis, $channel, $data) {
            self::$static++;
            if (!isset(self::$channelCallbacks[$channel])) {
                $obj = @unserialize($data);
                if ($obj instanceof MyJob) {
                    $obj->handle();
                    return;
                }
                dump('未找到指定方法-' . self::$static);
                return;
            }
            $callback = self::$channelCallbacks[$channel];

            call_user_func_array($callback, [$data]);
        });

        return true;
    }
}