<?php
require_once '../bootstrap.php';

$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect('127.0.0.1', 9501, 0.5)) {
    dd("连接tcp服务失败");
}

dump(1);
if (!$client->send("Hello Swoole ")) {
    dd("发送数据失败");
}

$data = $client->recv();

dump("接收服务器返回数据成功------" . $data);
if (!$data) {
    dd("从服务器接收数据失败");
}

$client->close();