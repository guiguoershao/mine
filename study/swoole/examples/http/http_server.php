<?php
require_once '../bootstrap.php';
$http = new swoole_http_server("0.0.0.0", 9501);


$http->on('request', function (swoole_http_request $request, swoole_http_response $response) {
    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end();
    }
    dump($request->get);
    dump($request->server);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole World. #".rand(1000, 9999)."</h1> <p>".json_encode($request->get)."</p>");
});

$http->on('close', function () {

});

$http->start();