<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-24
 * Time: 上午11:34
 */
namespace Library\Coroutines;
class Scheduler
{
    protected $taskQueue;

    protected $tid = 0;

    public function __construct()
    {
        /**
         * 原理就是维护了一个队列
         * 从编程角度看,协程的思想本质就是控制流的主动让出(yield)和恢复(resume)机制
         */
        $this->taskQueue = new \SplQueue();
    }

    /**
     * 增加一个任务
     * @param \Generator $task
     * @return int
     */
    public function addTask(\Generator $task)
    {
//        dump($task);
        $tid = $this->tid;
        $task = new Task($tid, $task);
        $this->taskQueue->enqueue($task);
        $this->tid++;
        return $tid;
    }

    /**
     * 把任务进入队列
     * @param Task $task
     */
    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    /**
     *
     */
    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            // 任务出队
            $task = $this->taskQueue->dequeue();
            $res = $task->run(); // 运行任务直到 yield

            if (!$task->isFinished()) {
                $this->schedule($task); // 任务如果还没用完全执行完毕,入队等下次执行
            }
        }
    }
}