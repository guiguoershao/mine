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
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        //  ignore_annotations 数组内的注解都会被注解扫描器忽略
        'ignore_annotations' => [
            'mixin',
        ],
        'collectors' => [
        ],
    ],
];
