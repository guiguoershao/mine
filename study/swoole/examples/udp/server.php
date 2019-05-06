<?php
require_once '../bootstrap.php';
//创建Server对象，监听 127.0.0.1:9905端口，类型为SWOOLE_SOCK_UDP
$server = new swoole_server('0.0.0.0', 9905, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

for ($i = 0; $i < 20; $i++) {
    $server->listen('0.0.0.0', 9906 + $i, SWOOLE_SOCK_UDP);
}

$server->set(['worker_num' => 4]);

//监听数据接收事件
$server->on('Packet', function (swoole_server $swooleServer, $data, $clientInfo) {
    //  向任意的客户端IP:PORT发送UDP数据包
    dump($clientInfo);
    $swooleServer->sendto($clientInfo['address'], $clientInfo['port'], "Swoole: $data", $clientInfo['server_socket']);
});

//启动服务器
$server->start();