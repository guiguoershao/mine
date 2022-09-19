<?php

$consumerOptionInfo = [
    'connect_timeout' => 5.0,
    'recv_timeout' => 5.0,
    'settings' => [
        // 根据协议不同，区分配置
        'open_eof_split' => true,
        'package_eof' => "\r\n",
        // 'open_length_check' => true,
        // 'package_length_type' => 'N',
        // 'package_length_offset' => 0,
        // 'package_body_offset' => 4,
    ],
    // 重试次数，默认值为 2，收包超时不进行重试。暂只支持 JsonRpcPoolTransporter
    'retry_count' => 2,
    // 重试间隔，毫秒
    'retry_interval' => 100,
    // 使用多路复用 RPC 时的心跳间隔，null 为不触发心跳
    'heartbeat' => 30,
    // 当使用 JsonRpcPoolTransporter 时会用到以下配置
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 32,
        'connect_timeout' => 10.0,
        'wait_timeout' => 3.0,
        'heartbeat' => -1,
        'max_idle_time' => 60.0,
    ],
];
return [
    'enable' => [
        'discovery' => true,
        'register' => true,
    ],
    'consumers' => [],
    'providers' => [],
    'drivers' => [
        'consul' => [
            'uri' => 'http://120.77.156.30:8011',
            'token' => '',
            'check' => [
                'deregister_critical_service_after' => '9m',
                'interval' => '1s',
            ],
        ],
    ],
];
