<?php
/**
 * 负载均衡
 */
require "../vendor/autoload.php";

$http = new Swoole\Http\Server('0.0.0.0', 3308);

$http->on('start', function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:3308\n";
});

$http->on('request', function ($request, $response) {
    $response->header('Content-Type', 'text/plain');
//    sleep(2);
    $response->end('Hello World 3308');
});

$http->start();