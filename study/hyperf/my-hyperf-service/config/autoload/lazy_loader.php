<?php
return [
    /**
     * 格式为：代理类名 => 原类名
     * 代理类此时是不存在的，Hyperf会在runtime文件夹下自动生成该类。
     * 代理类类名和命名空间可以自由定义。
     */
    'App\Service\LazyUserService' => \App\Service\UserServiceInterface::class
];
