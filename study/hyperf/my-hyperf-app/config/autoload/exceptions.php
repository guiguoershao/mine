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
    'handler' => [
        'http' => [
//            Hyperf\ExceptionHandler\Handler\WhoopsExceptionHandler::class,
            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            App\Exception\Handler\AppExceptionHandler::class,
//            Hyperf\Validation\ValidationExceptionHandler::class,// 默认的验证异常处理
            App\Exception\Handler\ApiExceptionHandler::class,
        ],
    ],
];
