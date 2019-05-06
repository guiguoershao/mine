<?php
require_once '../bootstrap.php';
$client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_SYNC);

// 连接到远程服务器
$client->connect('127.0.0.1', 9905);

// 向远程服务器发送数据
$client->send(serialize(['hello' => str_repeat('A', 600), 'rand' => rand(1, 100)]));

// 从服务器端接收数据
var_dump( $client->recv());

sleep(1);