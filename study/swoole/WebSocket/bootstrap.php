<?php

require_once '../vendor/autoload.php';
global $config;
$config = [
    'redis' => ['host' => '127.0.0.1', 'port' => '6379', 'pass' => '', 'db' => 1],
    'ws_link' => ['ws' => 'ws://127.0.0.2:9501', 'http' => 'http://127.0.0.2:9501'],
    'ws_connect' => ['ip'=>'127.0.0.2', 'port'=>'9501']
];
