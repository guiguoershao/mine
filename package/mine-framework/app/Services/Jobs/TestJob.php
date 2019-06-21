<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 下午5:13
 */

namespace App\Services\Jobs;


class TestJob extends MyJob
{
    protected $data = [];
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        file_put_contents(__ROOT__. '/tests/test.log', json_encode($this->data).PHP_EOL.PHP_EOL, FILE_APPEND);
    }
}