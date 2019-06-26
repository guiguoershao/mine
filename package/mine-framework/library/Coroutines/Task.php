<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-24
 * Time: 上午11:23
 */
namespace Library\Coroutines;
class Task
{
    protected $taskId;
    protected $coroutine;
    protected $beforeFirstYield = true;
    protected $sendValue;

    public function __construct($taskId, \Generator $generator)
    {
        $this->taskId = $taskId;
        $this->coroutine = $generator;
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * 判断task执行完毕了么有
     * @return bool
     */
    public function isFinished()
    {
        return !$this->coroutine->valid();
    }

    /**
     * 设置下次要传给协程的值, 比如 $Id = (yield $xxx) 这个值就给了$id了
     * @param $value
     */
    public function setSendValue($value)
    {
        $this->sendValue = $value;
    }

    /**
     * 运行任务
     * @return mixed
     */
    public function run()
    {
        if ($this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        } else {
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
        }
    }
}