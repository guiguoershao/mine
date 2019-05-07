<?php
require_once '../bootstrap.php';

$server = new swoole_server("127.0.0.1", 9501);

//监听连接进入事件
$server->on('connect', function (swoole_server $swoole_server, $fd) {
    dump("client: connect");
//    $swoole_server->send($fd, "客户端已经连接成功");
});
//监听数据接收事件
$server->on('receive', function (swoole_server $swoole_server, $fd, $from_id, $data) {
   // 投递异步任务
    dump("监听数据接收事件");
    $swoole_server->send($fd, "服务端已接收到数据: ".$data);
});

$server->on('close', function (swoole_server $swoole_server, $fd) {
   dump("客户端已断开连接");
});

$server->start();