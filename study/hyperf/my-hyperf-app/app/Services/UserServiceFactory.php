<?php


namespace App\Services;

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;


class UserServiceFactory
{
    // 实现一个 __invoke() 方法来完成对象的生产，方法参数会自动注入一个当前的容器实例
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(ConfigInterface::class);
        // 我们假设对应的配置的 key 为 cache.enable
        $enableCache = $config->get('cache.user_service.enable', false);
        return make(UserService::class, compact('enableCache'));
    }
}