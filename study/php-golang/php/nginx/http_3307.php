<?php
/**
 * 负载均衡
 */
require "../vendor/autoload.php";

$http = new Swoole\Http\Server('0.0.0.0', 3307);

$http->on('start', function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:3307\n";
});

$http->on('request', function ($request, $response) {
    $response->header('Content-Type', 'text/plain');
    $response->end('Hello World 3307');
});

$http->start();