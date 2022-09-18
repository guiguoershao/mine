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
    //  声明依赖, 使用 StdoutLoggerInterface 的地方, 由实际依赖的 StdoutLoggerFactory 实例化的类来完成
//    \Hyperf\Contract\StdoutLoggerInterface::class => \App\StdoutLoggerFactory::class,

//    'InnerHttp' => Hyperf\HttpServer\Server::class,
//    \App\Service\UserServiceInterface::class => \App\Service\UserService::class,
    \App\Service\UserServiceInterface::class => \App\Service\UserServiceFactory::class,


];
