<?php

namespace App;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;

class Log
{
    /**
     * @param string $name
     * @return \Psr\Log\LoggerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function get(string $name = 'app')
    {
        $logger = ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name);
        return $logger;
    }
}
