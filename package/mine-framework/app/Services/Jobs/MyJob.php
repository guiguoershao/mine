<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-21
 * Time: 下午5:12
 */

namespace App\Services\Jobs;


abstract class MyJob
{
    abstract public function handle();
}