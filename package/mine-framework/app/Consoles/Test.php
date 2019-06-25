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
use App\Services\Queues\MyRedisQueue;
use App\Services\Queues\QueueDaemon;
use Predis\Client;

class Test
{
    public function index()
    {
        $queue = new MyMsgQueue(RedisFacade::getFacadeRoot());

        for ($i = 1; $i <= 1000; $i++) {
            dump($i);
            $queue->publish("test:list", serialize(new TestJob(['i' => $i, 'data' => 'Hello World!'])));
        }
        $daemon = new QueueDaemon();
        $daemon->run();
    }

    private function redis(): \Redis
    {
        $redis = new \Redis();
        $redis->pconnect(config('redis.default.host'), config('redis.default.port'));
        $redis->select(config('redis.default.database'));
        return $redis;
    }

    /**
     * 发布
     */
    public function publish()
    {
        $queue = new MyRedisQueue($this->redis());
        for ($i = 1; $i <= 10000; $i++) {
            usleep(1000);
            $queue->publish('test-1', "消息--1--{$i}");
            $queue->publish('test-2', "消息--2--{$i}");
//            $this->redis()->publish('test', "这是消息--{$i}");
        }
    }

    /**
     * 订阅
     */
    public function subscribe()
    {
        ini_set('default_socket_timeout', -1);
        $queue = new MyRedisQueue($this->redis());
        $queue->setChannelCallback([
            'test-1' => function ($msg) {
                dump("这里是输出信息--1----------" . $msg);
            },
            'test-2' => function ($msg) {
                dump("这里是输出信息--2----------" . $msg);
            }
        ]);
        $queue->subscribe(['test-1', 'test-2']);
        /*$this->redis()->subscribe(['test'], function ($redis, $chan, $msg) {
            switch ($chan) {
                case 'test':
                    dump($msg);
                    break;
            }
        });*/

    }
}