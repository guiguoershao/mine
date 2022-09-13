<?php
return [
    // 服务提供者
    'providers' => [
        \App\Providers\RedisProvider::class
    ],

    //  门面别名
    'aliases' => [
        'Config' => \guiguoershao\Facades\ConfigFacade::class,
        'MyRedis' => \App\Facades\RedisFacade::class,
    ],

    'rpc_service_list' => [
        'trade' => [
            'class'   => \guiguoershao\Rpc\RpcClient::class,
            'host'    => '127.0.0.1',
            'port'    => 8003, // 订单服务端口
            'version'    => '2.0', // rpc服务版本
            'setting' => [
                'timeout'         => 0.5,
                'connect_timeout' => 1.0,
                'write_timeout'   => 10.0,
                'read_timeout'    => 0.5,
            ],
//            'packet'  => bean('rpcClientPacket'),
        ]
    ],
];