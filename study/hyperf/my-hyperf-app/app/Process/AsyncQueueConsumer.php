<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Cache\Driver\DriverInterface;
use Hyperf\Process\Annotation\Process;


class AsyncQueueConsumer extends ConsumerProcess
{
    /**
     * @var string
     */
    protected $queue = 'test';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var array
     */
    protected $config;
}
