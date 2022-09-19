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
// config/autoload/logger.php
$appEnv = env('APP_ENV', 'dev');
if ($appEnv == 'dev') {
    $formatter = [
        'class' => \Monolog\Formatter\LineFormatter::class,
        'constructor' => [
//            'format' => "||%datetime%||%channel%||%level_name%||%message%||%context%||%extra%\n",
            'dateFormat' => 'Y-m-d H:i:s',
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => true,
        ],
    ];
} else {
    $formatter = [
        'class' => \Monolog\Formatter\JsonFormatter::class,
        'constructor' => [],
    ];
}


return [
    'default' => [
        'handler' => [
//            'class' => Monolog\Handler\StreamHandler::class,
            'class' => Monolog\Handler\RotatingFileHandler::class, // 日期格式文件方式存储
            'constructor' => [
//                'stream' => BASE_PATH . '/runtime/logs/hyperf.log',
                'filename' => BASE_PATH . '/runtime/logs/hyperf.log', //日期格式文件方式存储
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => $formatter,
        /*'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],*/
    ],
];
