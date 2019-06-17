<?php
//(1)创建swool的http服务器对象
$serv = new swoole_http_server('0.0.0.0', 8000);
//(2)当浏览器链接点这个http服务器的时候,向浏览器发送helloworld
$serv->on('request', function ($request, $response) {
    //(2.1)$request包含这个请求的所有信息，比如参数
    //(2.2)$response包含返回给浏览器的所有信息，比如helloworld
    var_dump($request);
    var_dump($response);
    //(2.3)向浏览器发送helloworld
//    $response->end("hello world");
});
//(3)启动http服务器
$serv->start();