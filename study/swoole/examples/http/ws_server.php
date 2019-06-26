<?php
require_once '../bootstrap.php';
/**
 * WebSocket服务器是建立在Http服务器之上的长连接服务器，客户端首先会发送一个Http的请求与服务器进行握手。握手成功后会触发onOpen事件，表示连接已就绪，onOpen函数中可以得到$request对象，包含了Http握手的相关信息，如GET参数、Cookie、Http头信息等。
 * 建立连接后客户端与服务器端就可以双向通信了。
 *
 *
 * 客户端向服务器端发送信息时，服务器端触发onMessage事件回调
 * 服务器端可以调用$server->push()向某个客户端（使用$fd标识符）发送消息
 * 服务器端可以设置onHandShake事件回调来手工处理WebSocket握手
 * swoole_http_server是swoole_server的子类，内置了Http的支持
 * swoole_websocket_server是swoole_http_server的子类， 内置了WebSocket的支持
 */

$ws = new swoole_websocket_server("0.0.0.0", 9502);

// 监听WebSocket连接打开事件
$ws->on("open", function (swoole_websocket_server $server, swoole_http_request $request) {
    dump($request->fd, $request->get, $request->server);
    $server->push($request->fd, "hello, welcome\n");
    /**
     * 定时器
    swoole_timer_tick(200, function ($timer_id) use ($server, $request) {
        $server->push($request->fd, "hello, welcome ".rand(1000, 9999)."\n");
    });
    swoole_timer_after(3000, function () use ($server, $request) {
        echo "after 3000ms.\n";
        $server->push($request->fd, "hello, welcome after 3000ms".rand(1000, 9999)."\n");
    });*/
});

//  监听WebSocket消息事件
$ws->on('message', function (swoole_websocket_server $server, swoole_websocket_frame $frame) {
    dump("Message: {$frame->data}");
    $server->push($frame->fd, "Server response : {$frame->data}");
});


$ws->on('close', function (swoole_websocket_server $server, $fd) {
    dump("client-{$fd} is closed");
});
$ws->start();