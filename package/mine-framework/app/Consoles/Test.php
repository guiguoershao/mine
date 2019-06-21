<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 上午11:25
 */

namespace App\Consoles;


use App\Facades\RedisFacade;
use App\Services\Queues\MyMsgQueue;
use App\Services\Queues\QueueDaemon;

class Test
{
    public function index()
    {
        $queue = new MyMsgQueue(RedisFacade::getFacadeRoot());

        for ($i = 1; $i <= 10; $i++) {
            dump($i);
            $queue->publish("test:list", serialize(['i'=>$i, 'data'=>'Hello World!']));
        }
        $daemon = new QueueDaemon();
        $daemon->run();
    }
}