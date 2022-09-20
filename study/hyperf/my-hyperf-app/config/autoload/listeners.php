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
return [
    \Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler::class,
    \App\Listener\UserRegisteredListener::class,
    Hyperf\AsyncQueue\Listener\QueueLengthListener::class, // 框架自带了一个记录队列长度的监听器，默认不开启。您如果需要，可以自行添加到 listeners 配置中。

];
