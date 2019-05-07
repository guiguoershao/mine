<?php
require_once '../vendor/autoload.php';

$webSocketApp = new \WebSocket\WebSocketApp(['redis' => ['host' => '106.14.162.164', 'port' => '6379', 'pass' => 'fengyan.1992', 'db' => 1], 'ws' => ['ws' => '127.0.0.1:9501', 'http' => '127.0.0.1:9501']]);

$webSocketApp->start();