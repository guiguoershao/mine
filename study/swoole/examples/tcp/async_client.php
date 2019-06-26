<?php
require_once '../bootstrap.php';
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

//注册连接成功回调
$client->on("connect", function(swoole_client $cli) {
    dump("链接成功");
    $cli->send("hello world\n");
});


//注册数据接收回调
$client->on("receive", function(swoole_client $cli, $data){
    echo "Received: ".$data."\n";
    dump(11111111);
    Log::getInstance()->info('123', [$data]);
    $cli->close();
});

//注册连接失败回调
$client->on("error", function(swoole_client $cli){
    echo "Connect failed\n";
});

//注册连接关闭回调
$client->on("close", function($cli){
    echo "Connection close\n";
});

//发起连接
$client->connect('127.0.0.1', 9501, 0.5);