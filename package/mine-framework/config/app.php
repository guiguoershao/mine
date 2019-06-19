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
];