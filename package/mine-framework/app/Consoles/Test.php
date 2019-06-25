<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 上午11:25
 */

namespace App\Consoles;


use App\Facades\RedisFacade;
use App\Services\Jobs\TestJob;
use App\Services\Queues\MyMsgQueue;
use App\Services\Queues\QueueDaemon;
use Predis\Client;

class Test
{
    public function index()
    {
        $queue = new MyMsgQueue(RedisFacade::getFacadeRoot());

        for ($i = 1; $i <= 1000; $i++) {
            dump($i);
            $queue->publish("test:list", serialize(new TestJob(['i'=>$i, 'data'=>'Hello World!'])));
        }
        $daemon = new QueueDaemon();
        $daemon->run();
    }

    private function redis() : \Redis
    {
        $redis = new \Redis();
        $redis->connect(config('redis.default.host'), config('redis.default.port'));
        $redis->select(config('redis.default.database'));
        return $redis;
    }

    /**
     * 发布
     */
    public function publish()
    {
        for ($i = 1; $i <= 10000; $i++) {
            usleep(1000);
            $this->redis()->publish('test', "这是消息--{$i}");
        }
    }

    /**
     * 订阅
     */
    public function subscribe()
    {
        $this->redis()->subscribe(['test'], function ($redis, $chan, $msg) {
            switch ($chan) {
                case 'test':
                    dump($msg);
                    break;
            }
        });

    }
}