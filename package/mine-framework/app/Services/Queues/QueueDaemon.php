<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 下午2:52
 */

namespace App\Services\Queues;


use App\Facades\RedisFacade;

class QueueDaemon
{
    /**
     * 总进程数
     * @var int
     */
    public $processNum = 8;

    /**
     * 启动进程
     */
    public function run()
    {
        $pids = [];
        for ($i = 0; $i < $this->processNum; ++$i) {
            $pids[$i] = pcntl_fork();
            if ($pids[$i] == -1) {
                exit('fork error');
            } else if ($pids[$i]) {
                //这里是父进程空间，也就是主进程
                //我们的for循环第一次进入到这里时，pcntl_wait会挂起当前主进程，等待第一个子进程执行完毕退出
                //注意for循环的代码是在主进程的，挂起主进程，相当于当前的for循环也阻塞在这里了
                //第一个子进程退出后，然后再创建第二个子进程，到这里后又挂起，等待第二个子进程退出，继续创建第三个，等等。。
                pcntl_wait($status, WNOHANG); // WNOHANG 非阻塞
                dump($status);
            } else {
                //这里是子进程空间
                dump("父进程ID: " . posix_getppid() . " 进程ID : " . posix_getpid() . " {$i}");
                //我们让子进程等待3秒，再退出 sleep(5);
                $this->work();
                exit;
            }
        }
    }

    private function work()
    {
        $data = "";
        while (true) {
            usleep(10000); // 10ms 执行一次
            //  队列业务代码
            $queue = new MyMsgQueue(RedisFacade::getFacadeRoot());
            $queue->subscribe("test:list", $data);
            dump($data);
        }
    }
}