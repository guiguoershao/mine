<?php
require_once '../bootstrap.php';

$server = new \Swoole\Redis\Server('0.0.0.0', 10086, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
$server->setHandler('set', function ($fd, $data) use ($server) {
    dump($fd, $data);
    $client = new \Swoole\Coroutine\Redis();
    $client->connect('127.0.0.1', 6379);
    $client->set($data[0], $data[1]);
    $server->send($fd, \Swoole\Redis\Server::format(\Swoole\Redis\Server::INT, 1));
});

$server->start();