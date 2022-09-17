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
    'default' => [
        'driver' => Hyperf\Cache\Driver\RedisDriver::class, // 缓存驱动，默认为 Redis
        'packer' => Hyperf\Utils\Packer\PhpSerializerPacker::class, // 打包器
        'prefix' => 'c:', // 缓存前缀
    ],

    'co' => [
        'driver' => Hyperf\Cache\Driver\CoroutineMemoryDriver::class,
        'packer' => Hyperf\Utils\Packer\PhpSerializerPacker::class,
    ],

    'user_service' => [
        'enable' => true,
    ]
];
