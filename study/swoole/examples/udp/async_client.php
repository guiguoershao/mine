<?php
require_once '../bootstrap.php';
$client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_ASYNC);

//注册异步事件回调函数
$client->on('connect', function (swoole_client $swoole_client) {
    dump("connected");
    $swoole_client->send("Hello World");
});

$client->on('close', function () {
    dump("closed");
});

$client->on('error', function () {
    dump("error");
});

$client->on('receive', function (swoole_client $swoole_client, $data) {
    dump("received: " . $data);
    sleep(1);
//    $swoole_client->send("hello_" . rand(1000, 9999));
    Log::getInstance()->info('async-client', [$data]);
});

// 连接到远程服务器
$client->connect('127.0.0.1', 9905, 1);

//$client->close();