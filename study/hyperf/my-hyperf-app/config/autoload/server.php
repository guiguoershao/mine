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

use Hyperf\Server\Event;
use Hyperf\Server\Server;
use Swoole\Constant;

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
    'mode' => SWOOLE_PROCESS,
    'servers' => [
        [
            'name' => 'http',
            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => 8006,
//            'port' => 9501,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
            ],
        ],
        /*[
            'name' => 'InnerHttp',
            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => 8007,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_REQUEST => ['InnerHttp', 'onRequest'],
            ],
        ],*/

        [
            'name' => 'jsonrpc',
            'type' => Server::SERVER_BASE,
            'host' => '0.0.0.0',
            'port' => 8008,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_RECEIVE => [\Hyperf\JsonRpc\TcpServer::class, 'onReceive'],
            ],
            'settings' => [
                'open_eof_split' => true, // 启用 EOF 自动分包
                'package_eof' => "\r\n", // 设置 EOF 字符串
            ],
        ],
    ],
    'settings' => [
        Constant::OPTION_ENABLE_COROUTINE => true, // // 开启内置协程
        Constant::OPTION_WORKER_NUM => swoole_cpu_num(), // // 设置启动的 Worker 进程数
        Constant::OPTION_PID_FILE => BASE_PATH . '/runtime/hyperf.pid', // master 进程的 PID
        Constant::OPTION_OPEN_TCP_NODELAY => true, // TCP 连接发送数据时会关闭 Nagle 合并算法，立即发往客户端连接
        Constant::OPTION_MAX_COROUTINE => 100000,  // 设置当前工作进程最大协程数量  默认100000
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true, // 启用 HTTP2 协议解析
        Constant::OPTION_MAX_REQUEST => 100000, // 设置 worker 进程的最大任务数 默认 100000
        Constant::OPTION_SOCKET_BUFFER_SIZE => 2 * 1024 * 1024, // 配置客户端连接的缓存区长度
        Constant::OPTION_BUFFER_OUTPUT_SIZE => 2 * 1024 * 1024,

        // 静态资源
        'document_root' => BASE_PATH . '/public',
        'enable_static_handler' => true,
    ],
    'callbacks' => [
        Event::ON_WORKER_START => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [Hyperf\Framework\Bootstrap\PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT => [Hyperf\Framework\Bootstrap\WorkerExitCallback::class, 'onWorkerExit'],
    ],

    'enable' => [
        'discovery' => true,
        'register' => true,
    ],
    'consumers' => [
        /*[
            // name 需与服务提供者的 name 属性相同
            'name' => 'CalculatorService',
            // 服务接口名，可选，默认值等于 name 配置的值，如果 name 直接定义为接口类则可忽略此行配置，如 name 为字符串则需要配置 service 对应到接口类
            'service' => \App\JsonRpc\CalculatorServiceInterface::class,
            // 对应容器对象 ID，可选，默认值等于 service 配置的值，用来定义依赖注入的 key
            'id' => \App\JsonRpc\CalculatorServiceInterface::class,
            // 服务提供者的服务协议，可选，默认值为 jsonrpc-http
            // 可选 jsonrpc-http jsonrpc jsonrpc-tcp-length-check
            'protocol' => 'jsonrpc',
            // 负载均衡算法，可选，默认值为 random
            'load_balancer' => 'random',
            // 这个消费者要从哪个服务中心获取节点信息，如不配置则不会从服务中心获取节点信息
            'registry' => [
                'protocol' => 'consul',
                'address' => 'http://120.77.156.30:8011',
            ],
            // 如果没有指定上面的 registry 配置，即为直接对指定的节点进行消费，通过下面的 nodes 参数来配置服务提供者的节点信息
            'nodes' => [
                ['host' => '120.77.156.30', 'port' => 8008],
            ],
            // 配置项，会影响到 Packer 和 Transporter
            'options' => $consumerOptionInfo,
        ],*/
    ],
    'providers' => [],
    'drivers' => [
        'consul' => [
            'uri' => 'http://127.0.0.1:8011',
            'token' => '',
            'check' => [
                'deregister_critical_service_after' => '9m',
                'interval' => '1s',
            ],
        ],
    ],
];
