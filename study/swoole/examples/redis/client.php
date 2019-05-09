<?php
require_once '../bootstrap.php';

$client = new swoole_redis();

$client->connect('127.0.0.1', 6379, function (swoole_redis $swoole_redis, $result) {
    if ($result === false) {
        dump("连接redis server服务失败");
        return;
    }
    dump("connect redis server success");
    $swoole_redis->set('test', 'test', function (swoole_redis $swoole_redis, $result) {
        dump($result);
    });

    $swoole_redis->set('test:1', 'test-1', function (swoole_redis $swoole_redis, $result) {
        dump($result);
    });

    $swoole_redis->close();
});